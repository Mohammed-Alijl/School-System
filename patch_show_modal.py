path = 'resources/views/admin/grades/show_modal.blade.php'
with open(path, 'r') as f:
    content = f.read()

content = content.replace('class=\"modal-content shadow-lg border-0\" style=\"border-radius: 12px; overflow: hidden;\"', 'class=\"modal-content grade-show-modal-content\"')
content = content.replace('class=\"modal-header bg-light\"', 'class=\"modal-header grade-show-modal-header\"')
content = content.replace('class=\"modal-footer bg-light\"', 'class=\"modal-footer grade-show-modal-footer\"')
# To support dark theme well for the content
content = content.replace('bg-light', 'grade-show-section-card')

with open(path, 'w') as f:
    f.write(content)
print("show_modal patched")
