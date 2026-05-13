# Minimal Gym Management UI

This is a clean, professional, and system-like user interface for the Gym Management System. The design focuses on functionality, readability, and offline compatibility.

## Features

### 🎨 Design System
- **Light & Dark Themes**: Automatic theme switching with local storage persistence
- **Professional Styling**: Clean, minimal design that looks like real software systems
- **Offline-First**: Uses local assets, no external dependencies
- **Responsive**: Works on desktop and mobile devices

### 🧩 Components
- **Layout**: Sidebar navigation + top navbar + main content area
- **Cards**: Clean containers for content sections
- **Tables**: Professional data tables with hover effects
- **Forms**: Styled form inputs, selects, and buttons
- **Buttons**: Primary, outline, success, danger variants
- **Status Badges**: Color-coded status indicators
- **Navigation**: Active state highlighting and icons

### 🔧 Technical Features
- **Connection Status**: Real-time online/offline indicator
- **Theme Persistence**: Remembers user's theme preference
- **Accessibility**: Proper semantic HTML and keyboard navigation
- **Performance**: Lightweight CSS, no JavaScript frameworks

## Usage

### Using the Layout

To use this minimal layout in your views:

```blade
@extends('layouts.app-minimal')

@section('title', 'Page Title')

@section('content')
    <!-- Your page content here -->
@endsection
```

### Available CSS Classes

#### Layout
- `.app-layout` - Main layout container
- `.sidebar` - Left sidebar navigation
- `.main-content` - Main content area
- `.navbar` - Top navigation bar
- `.content` - Page content container

#### Components
- `.card` - Content container with border and shadow
- `.card-header` - Card header with background
- `.card-body` - Card content area
- `.btn` - Primary button
- `.btn-outline` - Outline button style
- `.btn-success` - Success button
- `.btn-danger` - Danger button

#### Forms
- `.form-group` - Form field container
- `.form-label` - Form field label
- `.form-input` - Styled input/select/textarea

#### Tables
- `.table` - Professional table styling
- `.table th` - Table header styling
- `.table td` - Table cell styling

#### Status & Utilities
- `.status-badge` - Status indicator
- `.status-success` - Green success status
- `.status-warning` - Yellow warning status
- `.status-error` - Red error status
- `.status-info` - Blue info status
- `.flex` - Flexbox display
- `.items-center` - Center items vertically
- `.justify-between` - Space between items
- `.gap-2`, `.gap-4` - Gap utilities
- `.text-sm` - Small text
- `.text-muted` - Muted text color
- `.hidden` - Hide element

## Customization

### Theme Colors

Modify the CSS variables in `:root` and `html.theme-dark` to customize colors:

```css
:root {
    --bg: #ffffff;           /* Background */
    --surface: #ffffff;      /* Card/surface backgrounds */
    --text: #1e293b;         /* Primary text */
    --accent: #3b82f6;       /* Primary accent color */
    --border: #e2e8f0;       /* Borders */
    /* ... other variables */
}
```

### Navigation

Update the sidebar navigation in `app-minimal.blade.php` to match your routes:

```blade
<a href="{{ route('your.route') }}" class="{{ request()->routeIs('your.route.*') ? 'active' : '' }}">
    <svg class="icon" ...>Icon</svg>
    Menu Item
</a>
```

## Example Pages

The following example pages demonstrate the UI components:

- `dashboard-minimal.blade.php` - Dashboard with stats cards and activity feeds
- `members/index-minimal.blade.php` - Members list with search, filters, and table
- `members/create-minimal.blade.php` - Member creation form

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance

- **CSS**: ~15KB minified
- **JavaScript**: ~2KB minified
- **No external dependencies**
- **Fast theme switching**
- **Optimized for offline use**

## Integration

To integrate this layout into your existing Laravel application:

1. **Update your views** to extend `layouts.app-minimal` instead of `layouts.app`
2. **Ensure routes exist** for the navigation links
3. **Add your content** in the `@section('content')` block
4. **Customize colors** by modifying the CSS variables if needed

The layout is designed to be drop-in compatible with your existing Laravel routes and controllers.