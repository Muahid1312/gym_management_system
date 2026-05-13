# Offline-First UI Implementation – Quick Reference

## 🔌 Connection Status in Navbar

The app now displays real-time connection status:

```
Navbar (top-right): [Online] or [Offline] or [Back Online]
Status Row: "Connection: Online/Offline" + "Sync Status: ..."
```

### Status Colors & Messages

| State | Color | Message | Behavior |
|-------|-------|---------|----------|
| **Online** | 🟢 Green | "Online" | Forms submit normally |
| **Offline** | 🔴 Red | "Offline" | Forms queue locally |
| **Back Online** | 🟢 Green (animated) | "Back Online" | Auto-syncs queued requests |

---

## 📋 Offline Form Behavior

### How It Works

1. **User fills form** (any form with `data-offline-sync="true"`)
2. **User clicks Submit**
3. **JavaScript checks:** `if (navigator.onLine) { submit normally }`
4. **If offline:**
   - Form submit prevented
   - Data stored in browser's `localStorage`
   - Toast notification: "Saved locally. Will sync when online."
   - Status shows: "Saved locally: X item(s) pending"
5. **When reconnected:**
   - Toast: "Back online — syncing queued changes."
   - All queued forms auto-submit
   - On success: "Offline data synced successfully"

### Supported Forms

All forms in the app support offline:
- ✅ Create Member
- ✅ Create Locker
- ✅ Assign Locker
- ✅ Release Locker
- ✅ Create Payment
- ✅ Any form marked `data-offline-sync="true"`

### Example HTML

```html
<form action="{{ route('lockers.assign') }}" 
      method="POST" 
      data-offline-sync="true"
      data-offline-sync-url="{{ route('lockers.assign') }}">
    @csrf
    <!-- form fields -->
</form>
```

### Queue Storage

Data stored in browser's `localStorage`:
- Key: `gym_offline_queue`
- Format: JSON array of `{ url, method, payload }`
- Persists across browser close
- Clears on successful sync

### Queue Payload Example

```json
{
  "url": "/lockers/assign",
  "method": "POST",
  "payload": {
    "member_id": "5",
    "locker_id": "3",
    "expiry_date": "2026-06-04",
    "temporary": "0"
  }
}
```

---

## 🎨 UI Elements

### Offline Banner (Alert)

```html
<div id="offlineBanner" class="alert alert-warning hidden">
    <strong>Offline Mode</strong> — your work is saved locally and will sync automatically when the network returns.
</div>
```

- **Hidden when online**
- **Shows when offline**
- **Background:** Orange/yellow
- **Icon:** ⚠️ Warning

### Status Row

```html
<div class="status-row">
    <span class="status-chip status-info">Connection: <span id="connectionStatus">Online</span></span>
    <span id="syncStatus" class="status-chip status-warning">Waiting for status...</span>
</div>
```

**Updates:**
- `connectionStatus`: "Online" or "Offline"
- `syncStatus`: Shows queue length, sync progress, or "All changes are synced"

### Navbar Connection Badge

```html
<span id="navbarConnection" class="status-chip status-info">Online</span>
```

**Updates on connection change:**
- Online: 🟢 "Online"
- Offline: 🔴 "Offline"
- Back Online: 🟢 "Back Online" (stays for ~5 seconds)

---

## 🔔 Notifications (Toasts)

Auto-dismissed after 3 seconds:

```javascript
showToast(message, type = 'success')
```

### Examples

**Going Offline:**
```
Toast: "Offline mode activated. Work will be stored locally."
Color: Yellow/warning
```

**Form Saved Offline:**
```
Toast: "Changes saved offline. They will sync automatically when online."
Color: Green/success
```

**Reconnected:**
```
Toast: "Back online — syncing queued changes."
Color: Green/success
```

**Sync Error:**
```
Toast: "Unable to sync saved items. Will retry automatically."
Color: Red/error
```

**Sync Complete:**
```
Toast: "Offline queue synchronized successfully."
Color: Green/success
```

---

## 🛰️ Service Worker Caching

The app's Service Worker caches key pages for offline viewing:

```javascript
const ASSETS_TO_CACHE = [
    '/',
    '/members/create',
    '/members',
    '/payments/create',
    '/lockers',
    '/lockers/create',
    '/receipts',
    '/service-worker.js',
];
```

### Behavior

1. **On install:** Caches all assets above
2. **On fetch (GET only):**
   - Try network first
   - If network fails → serve cached version
   - If not cached → serve fallback '/'
3. **On activate:** Clear old cache versions

### Result

- **Offline page views work** (loads cached version)
- **Offline forms can be filled** (data queued for later)
- **No hard failures** (fallback to home page)

---

## 💾 Offline Data Sync Logic

### Queue Processing (On Reconnect)

```javascript
syncQueuedRequests = async () => {
    // For each queued request:
    // 1. Send HTTP request (POST/GET/etc)
    // 2. Include CSRF token from page
    // 3. If fails → keep in queue for retry
    // 4. If succeeds → remove from queue
    // 5. Show progress in status badge
    // 6. Show toast on completion
}
```

### Retry Strategy

- **Automatic retries:** On next online event
- **Manual retry:** User can refresh page
- **Partial success:** Keeps failed items, syncs successful ones
- **Network error:** Keeps full queue, waits for next online

### Error Handling

```javascript
// Network error
"Sync paused due to network issue"

// Server validation error
Kept in queue, displayed in console

// Timeout
Auto-retries next online
```

---

## 🚀 Developer Usage

### For Forms

Just add `data-offline-sync="true"` to any form:

```html
<form action="{{ route('resource.store') }}" 
      method="POST" 
      data-offline-sync="true">
    @csrf
    <!-- fields -->
</form>
```

No other code needed! The layout handles everything.

### Clearing Queue (Debug)

```javascript
// In browser console:
localStorage.removeItem('gym_offline_queue');
```

### Check Queue Status

```javascript
// In browser console:
console.log(JSON.parse(localStorage.getItem('gym_offline_queue') || '[]'));
```

### Manual Sync Trigger

```javascript
// In browser console:
syncQueuedRequests();
```

---

## 🧪 Testing Offline Mode

1. **In Chrome DevTools:**
   - Network tab → Throttling → "Offline"
   - Forms will queue automatically
   - Fill form & submit → see "Saved locally"
   - Change back to "Online"
   - Forms auto-sync

2. **Or disable WiFi:** Real network disconnect test

3. **Check Status:**
   - Navbar badge changes color
   - Offline banner appears
   - Status row updates
   - Sync status shows queue count

---

## 📊 Status Chip Colors

```css
.status-chip.status-success  /* 🟢 Green */
.status-chip.status-warning  /* 🟡 Yellow */
.status-chip.status-error    /* 🔴 Red */
.status-chip.status-info     /* 🔵 Blue */
```

---

## 🔐 Security Notes

- ✅ CSRF token included in queued requests
- ✅ Server-side validation on replay
- ✅ No sensitive data in localStorage
- ✅ File uploads NOT queued (handled on next online)
- ✅ Each request includes fresh CSRF token

---

## 📝 Offline Form Hint

Optional hint shown to users:

```html
<div id="offlineFormHint" class="alert alert-info hidden">
    <strong>Offline support:</strong> supported forms will queue when disconnected and sync when the connection returns.
</div>
```

Shows when online, reminding users of the feature.

---

## 🎯 Quick Checklist

- [x] Connection status displayed
- [x] Offline banner visible
- [x] Forms auto-queue when offline
- [x] Auto-sync on reconnect
- [x] Status badges update
- [x] Toasts notify user
- [x] Service Worker caches pages
- [x] Queue persists across page reloads
- [x] CSRF tokens included
- [x] Error handling graceful

**Ready for production!** 🚀
