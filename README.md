# **Mendyfi Radius** #

    Created By Mendy
    Portfolio: https://mendiola.pages.dev
    Facebook: @mendylivium

### **Features**
- Sales Dashboard
- Voucher Generation
- Reseller Voucher
- Customizable Voucher
- Fair Use Policy   

#### **Compatible with any NAS/Router that Support Radius (WISPR)**

## **Preview**
### - **Dashboard**
![Dashboard](preview/dashboard.png)

### - **Voucher Generation**
![Voucher Generation](preview/generation.png)
![Voucher Generation](preview/generation-1.png)

### - **Active Voucher**
![Active Voucher](preview/active.png)

### - **Voucher Profile**
![Profile Voucher](preview/profile.png)
![Profile Voucher](preview/profile-1.png)

### - **Reseller**
![Reseller](preview/reseller.png)
![Reseller](preview/reseller-1.png)

### - **Voucher Template**
![Template](preview/template.png)
![Template](preview/template-1.png)
![Template Print](preview/print.png)

### - **Fair Use Policy**
![Template](preview/fup.png)
![Template](preview/fup-1.png)

### - **Sales Report**
![Template](preview/sales.png)

## Buy me a Coffee

Donation is appreaciated.

Paypal: https://paypal.me/RommelMendiola

GCash: 09553147435

## **Instruction** ##

First Install Docker.

Follow Step on this Link
https://github.com/mendylivium/docker-ubuntu


Clone this Repo.

Run this Command
```
git clone https://github.com/mendylivium/mendyfi-hotspot
```

Move to Directory
```
cd mendyfi-hotspot
```

Update Using Composer
```
docker compose run --rm composer update
```

Run Migration
```
docker compose run --rm artisan migrate:fresh --seed
```

Then Login to the Mendyfi Webpage

Username: admin

Password: admin@1234

### **Goto Config and Copy the date to your Router/NAS**
