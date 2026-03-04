import re

# 1. Update show_modal.blade.php
path_show = 'resources/views/admin/grades/show_modal.blade.php'
with open(path_show, 'r') as f:
    content_show = f.read()

# Replace the beginning of the script push with event delegation wrapper
content_show = content_show.replace("$('.view-btn').on('click', function() {", "$(document).on('click', '.view-btn', function(e) {\n                e.preventDefault();")

with open(path_show, 'w') as f:
    f.write(content_show)

# 2. Clean up archived.blade.php by removing redundant view-btn click handlers
path_archived = 'resources/views/admin/grades/archived.blade.php'
with open(path_archived, 'r') as f:
    content_archived = f.read()

# Regex to remove lines from // Handle Show Modal Populating through to the end of its block
pattern = r"[ \t]*// Handle Show Modal Populating\s*\$\('\.view-btn'\)\.on\('click', function\(\) \{.*?\}\);\s*"
content_archived = re.sub(pattern, "", content_archived, flags=re.DOTALL)

with open(path_archived, 'w') as f:
    f.write(content_archived)

# 3. Clean up index.blade.php
path_index = 'resources/views/admin/grades/index.blade.php'
with open(path_index, 'r') as f:
    content_index = f.read()

content_index = re.sub(pattern, "", content_index, flags=re.DOTALL)

with open(path_index, 'w') as f:
    f.write(content_index)

print("Modal JS fixed safely via event delegation and duplicates removed")
