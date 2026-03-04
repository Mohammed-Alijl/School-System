import re

def add_style(content, modal_id, light, dark):
    style = f'''<style>
    #{modal_id} {{
        --modal-accent: {light};
        --modal-accent-dark: {dark};
    }}
</style>

'''
    return style + content

def process_modal(path, modal_id, light, dark):
    with open(path, 'r') as f:
        content = f.read()

    # Add style block if not present
    if '<style>' not in content:
        content = add_style(content, modal_id, light, dark)

    # Replace basic form classes with the 'modern' ones copied from student-crud
    content = content.replace('class=\"form-group\"', 'class=\"form-group grade-form-group\"')
    content = content.replace('<label>', '<label class=\"grade-form-label\">')
    content = content.replace('class=\"form-control\"', 'class=\"form-control form-control-modern\"')
    # Keep the submit buttons classes
    content = content.replace('class=\"btn btn-primary\"', 'class=\"btn btn-save-grade\"')
    content = content.replace('class=\"btn btn-secondary\"', 'class=\"btn btn-cancel-grade\"')
    
    with open(path, 'w') as f:
        f.write(content)

process_modal('resources/views/admin/grades/add_modal.blade.php', 'addModal', '#4e73df', '#224abe')
process_modal('resources/views/admin/grades/edit_modal.blade.php', 'editModal', '#0ea573', '#057a52')
print("Modals updated")
