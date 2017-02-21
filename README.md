# Drupal 8 Insert Inline SVG images.

This is a workaround module that supports inserting SVGs inline from CKEditor in Drupal 8. This module should in theory be redundant when https://www.drupal.org/node/1014816 is resolved.

The code is mainly a copy of [D8 Editor File upload](https://www.drupal.org/project/editor_file), which has been updated to insert an img element with its src attributed set to the uploaded SVG file instead.

After saving a post with an inserted SVG, the editor will return to the built-in image widget, where additional formatting and a caption can be added.

## Installation
1. Download and enable the module as usual.
2. Go to your filters admin (admin/config/content/formats).
3. Edit the format on which you want to enable the insertion of SVGs.
4. Drag the 'S' icon to the "Active toolbar".
5. Configure the plugin settings in the vertical tabs above the toolbar
Save.
