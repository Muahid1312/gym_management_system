# Receipt System & Partner Integration - Quick Start Guide

## 🚀 Getting Started

### 1. Run Migrations
```bash
php artisan migrate
```

This creates the necessary database tables.

### 2. Configure Gym Settings
Access the Settings page and add your gym information:
- Gym Name
- Gym Phone
- Gym Email
- Gym Address

Or use tinker:
```bash
php artisan tinker
>>> App\Models\Setting::put('gym_name', 'Your Gym');
>>> App\Models\Setting::put('gym_phone', '+1 (555) 123-4567');
>>> App\Models\Setting::put('gym_email', 'contact@gym.com');
>>> App\Models\Setting::put('gym_address', '123 Main St, City, State');
```

### 3. Create Partners (Optional)
Navigate to **Partners** → **Add Partner** and create partners:
- **Name:** Partner name
- **Phone:** Contact number
- **Type:** Trainer, Affiliate, or Shop
- **Commission %:** Commission rate (e.g., 10 for 10%)

---

## 💳 Recording Payments (with Receipts)

### New Payment Form Fields

When recording a payment, you'll now see:

1. **Payment Method** - Select "Cash" or "Online"
2. **Partner (Commission)** - Select a partner if payment is referred

### Payment Recording
1. Go to **Payments** → **Add Payment**
2. Fill in member, plan, amount
3. Select payment method (Cash/Online)
4. Optionally select a partner
5. Click **Record Payment**

### What Happens Automatically
✅ Payment is recorded
✅ Member debt is updated
✅ **Receipt is automatically created** with unique number
✅ **Commission is automatically calculated** (if partner selected)

---

## 📄 Working with Receipts

### View All Receipts
1. Click **Receipts** in navigation
2. See all receipts with member, amount, and balance info
3. Filter by date or member (ready for enhancement)

### Download Receipt PDF
**From Payments List:**
1. Go to **Payments**
2. Click **Download** button on any payment with a receipt

**From Receipts List:**
1. Go to **Receipts**
2. Click **Download** button
3. PDF downloads as `Receipt-RCP-YYYY-MM-XXXXX.pdf`

### View Receipt Details
1. Click **View** on Receipts list
2. See formatted receipt information
3. View member details and payment status
4. Download PDF from the detail page

---

## 👥 Managing Partners

### Create Partner
1. Click **Partners** in navigation
2. Click **Add Partner**
3. Fill in:
   - Name (required)
   - Phone (required)
   - Type: Trainer / Affiliate / Shop
   - Commission % (0-100)
   - Check "Active" to enable commissions
4. Click **Create Partner**

### View Partner Details
1. Click **Partners**
2. Click partner name
3. See:
   - Total earnings
   - Paid earnings
   - Unpaid earnings
   - Recent commissions
   - Referred members count

### Edit Partner
1. Go to partner details
2. Click **Edit**
3. Update information
4. Click **Update Partner**

### Delete Partner
1. Go to partner edit page
2. Click **Delete** button
3. Confirm deletion

---

## 💰 Commission Management

### View Commissions
**For Individual Partner:**
1. Go to **Partners**
2. Click partner name
3. Scroll to "Recent Commissions"
4. See all commissions for that partner

### View Detailed Earnings Report
1. Go to **Partners**
2. Click partner name
3. Click **Earnings Report**
4. See comprehensive earnings breakdown with all commissions

### Mark Commission as Paid
**Single Commission:**
1. Go to partner's Earnings Report
2. Check the commission row's checkbox
3. Click **Mark Selected as Paid**
4. Commission is marked paid with timestamp

**Bulk Mark Commissions:**
1. Go to partner's Earnings Report
2. Check multiple commission checkboxes
3. Click **Mark Selected as Paid**
4. All selected commissions marked as paid

---

## 📊 Understanding the Data

### Receipt Number Format
`RCP-2026-05-00001`
- **RCP** - Receipt prefix
- **2026** - Year
- **05** - Month
- **00001** - Sequential number (resets monthly)

### Commission Calculation
```
Commission Amount = Payment Amount × Commission Percentage / 100

Example:
- Payment: $100
- Commission %: 10%
- Commission: $100 × 10 / 100 = $10
```

### Member Debt Calculation
```
Remaining Balance = Plan Price - Total Payments

Example:
- Plan Price: $500
- Payment 1: $200
- Payment 2: $150
- Remaining Balance: $500 - $200 - $150 = $150
```

---

## 🔄 Workflow Examples

### Example 1: Simple Cash Payment
1. Member pays $100 in cash for $500 plan
2. Record payment:
   - Amount: $100
   - Method: Cash
   - Partner: (none)
3. System automatically:
   - Creates receipt RCP-2026-05-00001
   - Updates debt to $400
   - No commission created

### Example 2: Referred Payment with Commission
1. Member referred by "John Trainer" pays $100
2. Record payment:
   - Amount: $100
   - Method: Online
   - Partner: John Trainer (10% commission)
3. System automatically:
   - Creates receipt RCP-2026-05-00002
   - Updates debt to $400
   - Creates commission: $100 × 10% = $10
   - Commission marked as unpaid (pending)

### Example 3: Bulk Commission Payment
1. You want to pay John Trainer for all his pending commissions
2. Go to **Partners** → John Trainer → **Earnings Report**
3. See: Total unpaid earnings = $150 (15 commissions × $10)
4. Check all unpaid commissions
5. Click **Mark Selected as Paid**
6. All 15 commissions now show as "Paid" with date/time

---

## 📱 Mobile Usage

### Responsive Features
- All pages work on mobile devices
- Receipt PDF downloads on mobile
- Tables are scrollable on small screens
- Touch-friendly buttons

### Mobile Workflow
1. Quick payment recording on mobile
2. Receipt generated immediately
3. Partner can view earnings on their phone

---

## ⚙️ Admin Features

### Dashboard Enhancements (Ready)
- Total receipts this month
- Total commissions owed
- Partner earnings overview

### Reports (Ready)
- Export commission reports
- Payment method breakdown
- Partner performance metrics

---

## 🎯 Best Practices

### For Receipts
✅ Always select payment method (cash or online)
✅ Add notes for partial payments explaining what they're for
✅ Download receipt immediately after payment for records
✅ Keep receipts for accounting and tax purposes

### For Partners
✅ Set accurate commission percentages
✅ Keep partner information updated
✅ Mark commissions as paid promptly
✅ Generate earnings reports monthly
✅ Use partner type to organize by role

### For Members
✅ Link referred members to their partner/referrer
✅ Track debt carefully with partial payments
✅ Provide receipt to member for their records

---

## 🔍 Viewing Related Data

### From Payment → Receipt
1. Go to **Payments**
2. See receipt download button
3. Click to download or view receipt

### From Member → Payments & Receipts
1. Go to **Members**
2. Click member name
3. See their payments
4. Access receipts from there

### From Partner → Commissions
1. Go to **Partners**
2. Click partner name
3. View all commissions linked to them
4. See earnings summary

---

## 📋 Data Export (Ready for Enhancement)

Currently you can:
- View data in tables
- Download receipts as PDF
- Export partner earnings from reports

Future: CSV export, Excel reports, detailed analytics

---

## ❓ FAQ

**Q: What if I don't select a partner?**
A: Receipt is created, but no commission is generated. Payment is processed normally.

**Q: Can I change payment method after recording?**
A: Currently recorded payments cannot be edited. Delete and re-record if needed.

**Q: How are receipt numbers generated?**
A: Automatically with format RCP-YYYY-MM-XXXXX, sequential per month.

**Q: What if a member has a partner but we override it?**
A: The payment-specific partner takes priority over member's partner.

**Q: Can commissions be edited?**
A: Currently they can only be marked as paid or unpaid. Delete and re-record for corrections.

**Q: How is remaining balance calculated on receipt?**
A: Takes current member debt at time of receipt creation.

---

## 🆘 Troubleshooting

**Problem: Receipt not generating**
- Ensure migrations have run: `php artisan migrate`
- Check ReceiptService is properly configured

**Problem: Partner dropdown is empty**
- Go to Partners and create at least one
- Ensure partner is marked as "Active"

**Problem: Commission not calculating**
- Ensure partner is selected when recording payment
- Check partner has commission_percentage set
- Check partner is marked as "Active"

**Problem: PDF not downloading**
- Ensure DomPDF is installed: `composer require barryvdh/laravel-dompdf`
- Check storage permissions
- Try viewing PDF inline first

---

**Ready to use! Start recording payments with receipts today! 🎉**
