# WordPress.org Assets

This directory contains assets for the WordPress.org plugin directory. These files are **not included** in the plugin distribution ZIP (see `.distignore`).

## 📸 Screenshots

WordPress.org displays screenshots in numerical order matching the descriptions in `readme.txt`:

### Required Screenshots (1390x864px recommended)

1. **screenshot-1.png** - Format selection modal displaying all 10 post formats
2. **screenshot-2.png** - Format Switcher sidebar panel showing current format
3. **screenshot-3.png** - Quote format pattern with pullquote and attribution
4. **screenshot-4.png** - Chat Log block displaying Slack conversation
5. **screenshot-5.png** - Post Format Repair tool showing scan results
6. **screenshot-6.png** - Status format editor with 280-character counter
7. **screenshot-7.png** - Automatic format detection notification
8. **screenshot-8.png** - Gallery format pattern with responsive grid

### Screenshot Guidelines

- **Format**: PNG (preferred) or JPG
- **Recommended size**: 1390x864px (16:10 aspect ratio)
- **Max size**: 1MB per screenshot
- **Naming**: `screenshot-{number}.png` (matches readme.txt order)
- **Background**: Use a clean WordPress admin environment
- **Theme**: Default WordPress admin color scheme (recommended for consistency)

## 🎨 Plugin Header Banner

### banner-772x250.png (Required)
- Standard resolution banner shown at top of plugin page
- Size: exactly 772x250px
- Format: PNG or JPG
- Max size: 1MB

### banner-1544x500.png (Optional but recommended)
- Retina/HiDPI version (2x resolution)
- Size: exactly 1544x500px
- Format: PNG or JPG
- Max size: 1MB

## 🔲 Plugin Icon

### icon-256x256.png (Required)
- Square plugin icon shown in search results and plugin cards
- Size: exactly 256x256px
- Format: PNG with transparency (recommended)
- Max size: 1MB
- **Note**: WordPress.org also generates 128x128 version automatically

### icon.svg (Optional alternative)
- Vector version (recommended for best quality at all sizes)
- Must be exactly square (equal width/height viewBox)
- WordPress.org will rasterize at 256x256 and 128x128

## 📤 Uploading to WordPress.org

After plugin approval, assets are uploaded via SVN to the `assets` directory:

```bash
# Checkout SVN repo (after approval)
svn co https://plugins.svn.wordpress.org/post-formats-for-block-themes

# Copy assets
cp .wordpress-org/* post-formats-for-block-themes/assets/

# Commit to SVN
cd post-formats-for-block-themes/assets
svn add *.png
svn commit -m "Add plugin screenshots and banner"
```

## 🎨 Design Tips

### Screenshots
- Use a consistent WordPress environment (same theme colors, font size)
- Show realistic content (not lorem ipsum)
- Highlight key features with subtle annotations if needed
- Ensure text is readable at 1390x864px

### Banner
- Feature your plugin name/logo prominently
- Use your brand colors
- Keep it simple and professional
- Avoid text that's too small to read

### Icon
- Should work at very small sizes (32x32)
- Use a simple, recognizable symbol
- Avoid fine details that won't scale down
- Ensure good contrast for visibility

## 🔗 References

- [WordPress Plugin Assets Guidelines](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/)
- [Header Images Specifications](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/#header-images)
- [Plugin Icons Specifications](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/#plugin-icons)
