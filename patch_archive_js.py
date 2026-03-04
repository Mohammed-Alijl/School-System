import re

path = 'resources/views/admin/grades/archived.blade.php'
with open(path, 'r') as f:
    content = f.read()

js_handler = '''
            // Handle Show Modal Populating
            $('.view-btn').on('click', function() {
                var btn = $(this);
                $('#show-grade-name').text(btn.data('name'));
                $('#show-notes').text(btn.data('notes'));
                
                var statusBadge = $('#show-status-badge');
                if (btn.data('status') == 1) {
                    statusBadge.removeClass('badge-danger').addClass('badge-success').text(btn.data('status_text'));
                } else {
                    statusBadge.removeClass('badge-success').addClass('badge-danger').text(btn.data('status_text'));
                }

                var classrooms = btn.data('classrooms');
                var tbody = $('#classrooms-table-body');
                tbody.empty();
                
                if (classrooms && classrooms.length > 0) {
                    $('#classrooms-table').removeClass('d-none');
                    $('#no-classrooms-empty-state').addClass('d-none');
                    
                    $('#show-classrooms-count').text(classrooms.length);
                    
                    $.each(classrooms, function(index, classroom) {
                        var statusHtml = classroom.status == 1 
                            ? '<span class=\"label text-success d-flex\">{{ __(\"admin.global.active\") }}</span>' 
                            : '<span class=\"label text-danger d-flex\">{{ __(\"admin.global.disabled\") }}</span>';
                            
                        var classroomName = typeof classroom.name === 'object' 
                            ? (classroom.name['{{ app()->getLocale() }}'] || Object.values(classroom.name)[0])
                            : classroom.name;
                        
                        tbody.append('<tr><td>' + (index + 1) + '</td><td>' + classroomName + '</td><td>' + statusHtml + '</td></tr>');
                    });
                } else {
                    $('#classrooms-table').addClass('d-none');
                    $('#no-classrooms-empty-state').removeClass('d-none');
                    $('#show-classrooms-count').text('0');
                }
            });
        });
    </script>'''

content = content.replace('        });\n    </script>', js_handler)

with open(path, 'w') as f:
    f.write(content)
print("JS updated")
