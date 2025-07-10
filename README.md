# 🔔 Advanced Toaster Notification System on JAVASCRIPT (JS)

A highly customizable, animated JavaScript-based toast notification system.

Supports:
- ✅ Custom theme (light, dark, or fully custom)
- ✅ Per-type styling (success, error, info)
- ✅ Custom icons and icon colors
- ✅ Progress bar with custom colors
- ✅ Box shadows: light, dark, custom, or none
- ✅ Hover-to-pause, click-to-dismiss
- ✅ Smooth position-based animations

---

## 📦 Installation

1. **Add Toast Container in HTML:**
<div id="toast-container"></div>

2. Include Toaster Script and Styles:
Paste the full JavaScript and CSS code block in your HTML file.

3.Include Icon Library (Optional for Custom Icons)
 or add https://icons.nirajkumarsharma.com.np/main.css in you html file for defult icon

⚙️ Initialization;

    new Toaster({
     theme: 'custom', // light | dark | custom
     iconStyle: '2d', // 2d | 3d
     timeout: 4000,   // in ms
     position: 'top-right', // top-right | top-left | top-center | bottom-right | bottom-left | bottom-center

     boxShadow: 'custom', // false | light | dark | custom
     customShadowStyle: '0 8px 20px rgba(0,0,0,0.3)',

     // Optional per-type configuration
     customBg: {
      success: '#e6ffed',
      error: '#ffe5e5',
      info: '#e5f0ff',
     },
     customTextColor: {
      success: '#0f5132',
      error: '#842029',
      info: '#084298',
     },
     customBorderColor: {
      success: '#198754',
      error: '#dc3545',
      info: '#0d6efd',
     },
     customBarColor: {
      success: '#198754',
      error: '#dc3545',
      info: '#0d6efd',
     },
     customIcons: {
      success: 'fa fa-check-circle',
      error: 'fa fa-times-circle',
      info: 'fa fa-info-circle',
     },
     customIconColor: {
      success: '#198754',
      error: '#dc3545',
      info: '#0d6efd',
     }
    });


🚀 Usage
Call the global toaster() function:

    toaster(type, title, message, overrideOptions = {});
    
    EXAMPLE :
    toaster('success', 'Success!', 'Your data has been saved.');
    toaster('error', 'Error', 'Something went wrong.');
    toaster('info', 'FYI', 'This is an info message.');

  Available Types
  
   1.success
   
   2.error
   
   3.info

💡 Each type supports its own background, text color, icon, bar color, and border!

🧩 Per-Type Options
You can customize these per toast type:

| Option              | Description                   |
| ------------------- | ----------------------------- |
| `customBg`          | Background color              |
| `customTextColor`   | Text color                    |
| `customBorderColor` | Border color                  |
| `customBarColor`    | Progress bar color            |
| `customIcons`       | Icon class (e.g. FontAwesome) |
| `customIconColor`   | Icon color                    |


🎨 Theme

| Theme    | Description                                     |
| -------- | ----------------------------------------------- |
| `light`  | White background, black text (default fallback) |
| `dark`   | Dark background, white text                     |
| `custom` | Fully customizable per type                     |


🧠 If theme: 'custom' is used and a style (e.g., customBg.error) is not provided, the system falls back to light theme defaults.


🧱 Position Options

| Value           | Description                  |
| --------------- | ---------------------------- |
| `top-right`     | Top right corner             |
| `top-left`      | Top left corner              |
| `top-center`    | Top center (horizontally)    |
| `bottom-right`  | Bottom right corner          |
| `bottom-left`   | Bottom left corner           |
| `bottom-center` | Bottom center (horizontally) |


🪟 Box Shadow

| Value    | Shadow Example                  |
| -------- | ------------------------------- |
| `false`  | No shadow                       |
| `light`  | `0 4px 6px rgba(0,0,0,0.1)`     |
| `dark`   | `0 6px 12px rgba(0,0,0,0.3)`    |
| `custom` | Uses `customShadowStyle` string |


    EXAMPLE : 
        boxShadow: custom,
        customShadowStyle: 0 12px 25px rgba(255, 0, 0, 0.3)

🔄 Animations
| Direction           | Animation                |
| ------------------- | ------------------------ |
| `top-left/right`    | Slide in from left/right |
| `bottom-left/right` | Slide in from left/right |
| `top-center`        | Slide down               |
| `bottom-center`     | Slide up                 |


🚫 Dismiss + Pause

Hovering on the toast pauses its auto-close timeout
Clicking the close (×) icon dismisses it immediately


🧪 Advanced Per-Toast Override

    toaster('success', 'Overridden!', 'Using custom icon + color', {
      customIcons: { success: 'fa fa-star' },
      customBg: { success: '#f0f8ff' },
      customTextColor: { success: '#1c1c1c' },
      customIconColor: { success: '#f39c12' },
      boxShadow: 'dark',
    });

🧰 Features

⏱ Auto-dismiss after timeout
🖱 Hover to pause timeout
❌ Click to close manually
🎯 Smooth position-aware animations
💎 Theme-aware icons and progress bars
🔄 Global or per-toast config support

✅ License
Neeraj sharma
nirajkumarsharma.com.np
if any issues found please report at mail@nirajkumarsharma.com.npp
Free to use, modify, and integrate.

