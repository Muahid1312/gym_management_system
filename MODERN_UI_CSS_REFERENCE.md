# Modern Gym Management UI - CSS Reference Guide

## Color System

### Primary Colors
```css
--primary: #F97316;           /* Orange - Main accent */
--primary-dark: #EA580C;      /* Orange Dark - Hover state */
--primary-light: #FEDF89;     /* Orange Light - Disabled state */
```

### Secondary Colors
```css
--secondary: #1E40AF;         /* Deep Blue - Charts, secondary elements */
--sidebar-bg: #0F172A;        /* Dark Navy - Sidebar background */
--sidebar-text: #E2E8F0;      /* Light Gray - Sidebar text */
--sidebar-active: #F97316;    /* Orange - Active sidebar item */
```

### Content Area
```css
--content-bg: #FFFFFF;        /* White - Main content background */
--border-color: #E2E8F0;      /* Light Gray - Borders */
--shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
--shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
```

### Text Colors
```css
--text-primary: #1F2937;      /* Dark Gray - Main text */
--text-secondary: #64748B;    /* Medium Gray - Secondary text */
--text-muted: #94A3B8;        /* Light Gray - Muted text */
```

### Status Colors
```css
--active-bg: #DCFCE7;         /* Light Green background */
--active-text: #16A34A;       /* Green text */

--expired-bg: #FEE2E2;        /* Light Red background */
--expired-text: #DC2626;      /* Red text */

--pending-bg: #FEF9C3;        /* Light Yellow background */
--pending-text: #CA8A04;      /* Amber text */

--info-bg: #EFF6FF;           /* Light Blue background */
--info-text: #1E40AF;         /* Blue text */
```

## Typography

### Font Families
```css
font-family: 'Inter', 'Poppins', sans-serif;
```

### Font Sizes
```css
/* Headings */
h1: 32px, font-weight: 700    /* Page titles */
h2: 24px, font-weight: 700    /* Section titles */
h3: 18px, font-weight: 700    /* Card titles */
h4: 16px, font-weight: 700    /* Subtitles */

/* Body Text */
p:  14px, font-weight: 400    /* Regular text */
p:  12px, font-weight: 400    /* Small text */

/* Labels & Buttons */
label: 14px, font-weight: 600 /* Form labels */
button: 14px, font-weight: 600 /* Button text */
badge: 12px, font-weight: 600 /* Badge text */
```

### Font Weights
```css
400: Regular body text
500: Slightly emphasize text
600: Labels, buttons, navigation
700: Headings, titles
```

## Spacing System

### Padding & Margins
```css
4px   (0.25rem)
8px   (0.5rem)
12px  (0.75rem)
16px  (1rem)   /* Default gap */
20px  (1.25rem)
24px  (1.5rem) /* Card padding, content padding */
```

### Common Spaces
```css
.content-area:
  padding: 24px

.card:
  padding: 24px

.card-header:
  padding-bottom: 16px
  margin-bottom: 24px

.form-group:
  margin-bottom: 20px
```

## Border Radius

```css
8px   /* Smaller elements: inputs, small buttons */
12px  /* Main elements: cards, buttons, modals */
9999px /* Pill-shaped: buttons, badges, full-width rounded */
50%   /* Circles: avatars, full-circle icons */
```

## Shadows

### Elevations
```css
shadow-sm:  0 1px 3px rgba(0, 0, 0, 0.05)
            /* Subtle dividers, borders */

shadow:     0 4px 24px rgba(0, 0, 0, 0.08)
            /* Cards, regular elements */

shadow-lg:  0 8px 32px rgba(0, 0, 0, 0.12)
            /* Hover state, elevated elements */

shadow-xl:  0 24px 70px rgba(0, 0, 0, 0.08)
            /* Modals, popovers */
```

## Component Styles

### Sidebar
```css
.sidebar {
    width: 260px;
    background-color: var(--sidebar-bg);
    color: var(--sidebar-text);
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
}

.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid rgba(226, 232, 240, 0.1);
}

.nav-item {
    padding: 12px 20px;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.nav-item:hover {
    background-color: rgba(249, 115, 22, 0.1);
    border-left-color: var(--primary);
}

.nav-item.active {
    background-color: rgba(249, 115, 22, 0.15);
    border-left-color: var(--primary);
    color: var(--primary);
}
```

### Cards
```css
.card {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    padding: 24px;
}

.card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    transition: box-shadow 0.2s ease;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border-color);
}
```

### Stat Cards
```css
.stat-card {
    display: flex;
    gap: 16px;
    padding: 24px;
    border-radius: 12px;
    box-shadow: var(--shadow);
    background-color: white;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon.blue {
    background-color: #EFF6FF;
    color: #1E40AF;
}

.stat-icon.green {
    background-color: #DCFCE7;
    color: #16A34A;
}

.stat-icon.orange {
    background-color: #FFEDD5;
    color: var(--primary);
}

.stat-icon.purple {
    background-color: #F3E8FF;
    color: #7C3AED;
}
```

### Buttons
```css
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
}

.btn-secondary {
    background-color: #E2E8F0;
    color: #475569;
}

.btn-secondary:hover {
    background-color: #CBD5E1;
}

.btn-pill {
    border-radius: 9999px;
}
```

### Badges
```css
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-active {
    background-color: #DCFCE7;
    color: #16A34A;
}

.badge-expired {
    background-color: #FEE2E2;
    color: #DC2626;
}

.badge-pending {
    background-color: #FEF9C3;
    color: #CA8A04;
}

.badge-info {
    background-color: #EFF6FF;
    color: #1E40AF;
}
```

### Tables
```css
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #F8FAFC;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #475569;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

td {
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
    color: #1F2937;
}

tbody tr:hover {
    background-color: #F8FAFC;
}

tbody tr:nth-child(even) {
    background-color: #FAFBFC;
}
```

### Forms
```css
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 14px;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}

.form-group input.error {
    border-color: #EF4444;
}

.form-error {
    font-size: 12px;
    color: #EF4444;
    margin-top: 6px;
}
```

### Drawer
```css
.drawer {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    background-color: white;
    box-shadow: -4px 0 24px rgba(0, 0, 0, 0.12);
    display: flex;
    flex-direction: column;
    z-index: 1500;
    transition: right 0.3s ease;
    overflow-y: auto;
}

.drawer.active {
    right: 0;
}

.drawer-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.drawer-body {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
}

.drawer-footer {
    padding: 24px;
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 12px;
}
```

## Responsive Utilities

### Breakpoints
```css
/* Mobile-first approach */
@media (max-width: 640px) {
    /* Mobile devices */
}

@media (max-width: 768px) {
    /* Tablets */
}

@media (max-width: 1024px) {
    /* Small desktops */
}

@media (min-width: 1200px) {
    /* Large desktops */
}
```

### Grid Layouts
```css
/* 4-column grid (Desktop) */
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 20px;

/* 2-column grid (Tablet) */
display: grid;
grid-template-columns: repeat(2, 1fr);
gap: 20px;

/* 1-column grid (Mobile) */
display: grid;
grid-template-columns: 1fr;
gap: 20px;

/* Auto-responsive */
display: grid;
grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
gap: 20px;
```

### Flexbox Layouts
```css
/* Sidebar + Content */
display: flex;
flex-direction: row;
min-height: 100vh;

.sidebar {
    width: 260px;
    flex-shrink: 0;
}

.main-content {
    flex: 1;
    overflow: hidden;
}

/* Header Layout */
display: flex;
align-items: center;
justify-content: space-between;
gap: 20px;

.header-left {
    flex: 1;
    display: flex;
    gap: 20px;
}

.header-right {
    display: flex;
    gap: 16px;
    flex-shrink: 0;
}
```

## Animation & Transitions

### Smooth Transitions
```css
transition: all 0.2s ease;
transition: background-color 0.2s ease;
transition: box-shadow 0.2s ease;
transition: transform 0.2s ease;
```

### Hover Effects
```css
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

.btn:hover {
    background-color: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
}
```

### Pulse Animation
```css
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.skeleton {
    animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
```

## Utility Classes

### Display
```css
.hidden { display: none; }
.flex { display: flex; }
.grid { display: grid; }
.block { display: block; }
.inline-flex { display: inline-flex; }
```

### Text
```css
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }
.font-bold { font-weight: 700; }
.font-semibold { font-weight: 600; }
```

### Sizing
```css
.w-full { width: 100%; }
.h-full { height: 100%; }
.w-screen { width: 100vw; }
.h-screen { height: 100vh; }
```

## Accessibility

### Focus States
```css
.btn:focus,
.input:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}
```

### High Contrast
```css
@media (prefers-contrast: more) {
    /* Use higher contrast colors */
}
```

### Reduced Motion
```css
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

## Performance Tips

1. **Use CSS variables** for easy theme changes
2. **Minimize animations** on mobile devices
3. **Use CSS Grid** for responsive layouts
4. **Lazy load** images and assets
5. **Cache** static files
6. **Minify** CSS in production

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari 14+, Chrome Mobile)

---

**Version**: 1.0  
**Last Updated**: June 6, 2026
