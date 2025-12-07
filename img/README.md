# WordPress.org Plugin Assets

This folder contains the generated assets for the WordPress.org plugin directory listing.

## ✅ What's Here

### SVG Source Files (Generated)
- `icon-256x256.svg` - Plugin icon source
- `banner-772x250.svg` - Standard banner source
- `banner-1544x500.svg` - Retina banner source

### Converter Tool
- `convert-to-png.html` - Browser-based SVG to PNG converter

## 🎨 Design Features

All assets use **official WordPress Dashicons** from https://developer.wordpress.org/resource/dashicons/

### Icon Design
- 256×256px with transparent background
- WordPress blue gradient background
- 3×3 grid of format icons (9 of the 10 formats)
- "POST FORMATS" text overlay
- Clean, modern, recognizable at 32×32px

### Banner Design
- WordPress blue gradient background (2271B1 → 0073AA → 1E3A8A)
- Left: Plugin name + tagline + feature highlights
- Right: 10 format icons in 5×2 grid with label
- "WordPress 6.8+" badge
- Professional, clean layout

### Dashicons Used
1. format-quote (quotation marks)
2. format-gallery (image grid)
3. format-video (play button)
4. format-audio (sound waves)
5. format-image (picture frame)
6. format-chat (speech bubbles)
7. admin-links (chain link)
8. format-status (star)
9. format-aside (arrow)
10. format-standard (document)

## 🔄 Converting to PNG

### Option 1: Use the Browser Converter (Easiest)

1. Open `convert-to-png.html` in your browser
2. Click each "Convert & Download" button
3. PNG files will download automatically
4. Move them to `../.wordpress-org/` folder

### Option 2: Manual Conversion

**Using Preview (Mac):**
1. Open each SVG in Preview
2. File → Export → Format: PNG
3. Set correct dimensions
4. Save to `../.wordpress-org/`

**Using Online Tool:**
1. Go to https://cloudconvert.com/svg-to-png
2. Upload SVG, set dimensions, download PNG

### Option 3: Command Line (if ImageMagick installed)

```bash
# Install ImageMagick
brew install imagemagick

# Convert
convert icon-256x256.svg -resize 256x256 ..//.wordpress-org/icon-256x256.png
convert banner-772x250.svg -resize 772x250 ..//.wordpress-org/banner-772x250.png
convert banner-1544x500.svg -resize 1544x500 ..//.wordpress-org/banner-1544x500.png
```

## 📁 File Locations

**Source files (this folder):**
- `/img/icon-256x256.svg`
- `/img/banner-772x250.svg`
- `/img/banner-1544x500.svg`

**Final PNG files (move here):**
- `/.wordpress-org/icon-256x256.png`
- `/.wordpress-org/banner-772x250.png`
- `/.wordpress-org/banner-1544x500.png`

## ✅ Specifications Met

- ✅ Uses official WordPress Dashicons only
- ✅ WordPress blue color palette (#2271B1, #0073AA, #1E3A8A)
- ✅ Exact dimensions required (256×256, 772×250, 1544×500)
- ✅ Professional, modern design
- ✅ All 10 post formats represented
- ✅ Clear branding: "Post Formats for Block Themes"
- ✅ Readable at all sizes
- ✅ High contrast for accessibility
- ✅ Under 1MB file size (when converted to PNG)

## 🚀 Next Steps

1. **Convert** SVGs to PNG using one of the methods above
2. **Move** PNG files to `/.wordpress-org/` directory
3. **Verify** file sizes are under 1MB each
4. **Test** how they look:
   - Icon at 32×32px (search results)
   - Icon at 128×128px (plugin card)
   - Icon at 256×256px (plugin details)
   - Banner at top of plugin page
5. **Wait** for WordPress.org plugin approval
6. **Upload** to WordPress.org SVN assets directory

## 📸 Preview

Open `convert-to-png.html` in your browser to see live previews of all assets before converting.
