# WordPress.org Assets Checklist

## 📸 Required Screenshots (8 total)

Save as PNG files at 1390x864px (recommended size):

### ✅ screenshot-1.png
**Caption**: Format selection modal displaying all 10 post formats with descriptive icons and labels when creating a new post

**What to capture**:
- Open WordPress editor → Click "Add New Post"
- The format selection modal should appear
- Shows all 10 formats in a card grid layout
- Each card has an icon, title, and description
- Capture with good lighting/contrast

---

### ✅ screenshot-2.png
**Caption**: Format Switcher sidebar panel showing current format, auto-detection status, and dropdown to switch formats mid-edit

**What to capture**:
- WordPress editor with a post open
- Format Switcher panel visible in right sidebar
- Shows current format badge
- Auto-detection status indicator visible
- Format dropdown menu expanded or ready to use

---

### ✅ screenshot-3.png
**Caption**: Quote format pattern with locked pullquote block, attribution field, and enhanced typography adapting to theme

**What to capture**:
- Post using Quote format
- Pullquote block visible with sample quote
- Attribution field showing author name
- Block toolbar showing lock icon (indicating it's locked)
- Enhanced typography visible

---

### ✅ screenshot-4.png
**Caption**: Chat Log block displaying Slack conversation with avatars, usernames, timestamps, and bubble-style formatting

**What to capture**:
- Post using Chat format
- Chat Log block with multiple messages
- Slack-style formatting (avatars on left, bubbles on right)
- Usernames and timestamps visible
- Color-coded user bubbles

---

### ✅ screenshot-5.png
**Caption**: Post Format Repair tool showing scan results, detected mismatches, suggested format changes, and one-click repair

**What to capture**:
- Go to Tools → Post Format Repair
- Run scan to show results table
- Display posts with format mismatches
- Show "Repair" buttons for each mismatch
- Include scan summary (X posts scanned, Y mismatches found)

---

### ✅ screenshot-6.png
**Caption**: Status format editor with real-time 280-character counter, validation, and visual feedback like social media

**What to capture**:
- Post using Status format
- Text area with character counter visible
- Counter showing remaining characters (e.g., "127 / 280")
- Validation feedback (green if under limit, red if over)
- Social-media-style composer UI

---

### ✅ screenshot-7.png
**Caption**: Automatic format detection notification suggesting Quote format after inserting pullquote block

**What to capture**:
- WordPress editor with a post open
- User just inserted a Pullquote block
- Blue notification banner appears at top: "We detected you might want to use Quote format. Switch now?"
- Shows "Switch Format" and "Dismiss" buttons
- Context showing the pullquote block below

---

### ✅ screenshot-8.png
**Caption**: Gallery format pattern with locked gallery block displaying responsive grid layout adapting to theme columns

**What to capture**:
- Post using Gallery format
- Gallery block with multiple images (6-9 images work well)
- Responsive grid layout visible
- Block toolbar showing lock icon
- Images displaying in clean grid

---

## 🎨 Required Banners

### ✅ banner-772x250.png (Required)
**Standard plugin header banner**

**Specifications**:
- Size: exactly 772×250px
- Format: PNG or JPG
- Max file size: 1MB

**Design ideas**:
- Feature plugin name: "Post Formats for Block Themes"
- Use post format icons (quote bubble, gallery grid, video play, etc.)
- Tagline: "Bring WordPress Post Formats to Block Themes"
- Use brand colors with good contrast
- Keep text large enough to read

---

### ✅ banner-1544x500.png (Recommended)
**Retina/HiDPI banner (2x resolution)**

**Specifications**:
- Size: exactly 1544×500px
- Format: PNG or JPG
- Max file size: 1MB

**Design**: Same design as 772×250 banner, just at 2x resolution

---

## 🔲 Required Icon

### ✅ icon-256x256.png (Required)
**Square plugin icon**

**Specifications**:
- Size: exactly 256×256px
- Format: PNG with transparency (recommended)
- Max file size: 1MB

**Design ideas**:
- Simple, recognizable symbol
- Must work at small sizes (32×32)
- Consider using a post format symbol (quote bubble, gallery grid, etc.)
- Use transparent background
- High contrast for visibility

**Alternative**: icon.svg (vector format, must be exactly square)

---

## 📋 Creation Tips

### Tools for Screenshots
- **macOS**: Shift+Cmd+4 → Space → Click window (captures clean window)
- **Windows**: Windows+Shift+S (Snipping Tool)
- **Browser DevTools**: F12 → Device toolbar → Set to 1390×864px
- **Editing**: Use Preview (Mac) or Paint (Windows) to resize if needed

### Tools for Banners/Icons
- **Figma** (free): Professional design tool
- **Canva** (free): Easy template-based design
- **Photoshop/Illustrator**: Professional tools
- **GIMP** (free): Open-source alternative to Photoshop
- **Inkscape** (free): Open-source vector graphics

### Screenshot Best Practices
1. Use default WordPress admin color scheme (blue)
2. Clean browser window (no bookmarks bar, extensions)
3. Use realistic content (not "lorem ipsum")
4. Consistent font size (browser zoom at 100%)
5. Good lighting/contrast
6. No sensitive information visible

### Banner Best Practices
1. Keep it simple and professional
2. Plugin name should be prominent and readable
3. Use 2-3 colors max
4. Avoid tiny text
5. Test how it looks at actual size on WordPress.org

---

## 📤 Uploading to WordPress.org (After Approval)

Once your plugin is approved, you'll upload these assets via SVN:

```bash
# 1. Checkout your plugin's SVN repository
svn co https://plugins.svn.wordpress.org/post-formats-for-block-themes

# 2. Copy assets to the assets directory
cd post-formats-for-block-themes
cp ../.wordpress-org/*.png assets/
cp ../.wordpress-org/*.jpg assets/  # if using JPG

# 3. Add and commit
cd assets
svn add *.png *.jpg
svn commit -m "Add plugin screenshots, banner, and icon"
```

WordPress.org will automatically display them on your plugin page!

---

## ✅ Quick Checklist

Before submitting to WordPress.org, verify:

- [ ] All 8 screenshots created and named correctly
- [ ] Screenshots are 1390×864px (or similar 16:10 ratio)
- [ ] Each screenshot matches its caption in readme.txt
- [ ] banner-772x250.png created
- [ ] banner-1544x500.png created (recommended)
- [ ] icon-256x256.png created with transparency
- [ ] All images under 1MB each
- [ ] All files in `.wordpress-org/` directory
- [ ] Files tracked in git
- [ ] Files excluded from plugin ZIP (via .distignore)

---

## 🔗 Official Documentation

- [WordPress Plugin Assets Guide](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/)
- [Plugin Headers](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/#header-images)
- [Plugin Icons](https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/#plugin-icons)
