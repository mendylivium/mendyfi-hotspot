# **Mendyfi Radius** #

    Created By Mendy
    Portfolio: https://mendiola.pages.dev
    Facebook: @mendylivium

### **Features**
- Multi User / Multi Tenancy
- Sales Dashboard
- Voucher Generation
- Reseller Voucher
- Customizable Voucher
- Fair Use Policy   
- Auto Database Backup (Manual Import)

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

## **Instruction** ##

First Install Docker.

Follow Step on this Link
https://github.com/mendylivium/docker-ubuntu


Clone this repository. Run the following command:
```
git clone https://github.com/mendylivium/mendyfi-hotspot.git
```

Move to the project directory:
```
cd mendyfi-hotspot
```

Run All Containers
```
docker compose up -d
```


Update dependencies using Composer
```
docker compose run --rm composer update
```

Run Migration
```
docker compose run --rm artisan migrate:fresh --seed
```

### - **CHANGE CENTRAL DOMAIN [OPTIONAL]**

Edit .env and Change the "CENTRAL_DOMAINS"

This is optional you can Access Admin Page on the Domain Provided

![Template](preview/central_domains.png)

```
...
CENTRAL_DOMAINS=yourdomain
...
```

### - **LOGIN TO ADMIN PAGE**
If provide domain in "CENTRAL_DOMAINS"
Goto http://< your domain >/auth/login

If dont,
Goto http://< your ip>:8090/auth/login

![Template](preview/admin_login.png)

Then, log in to the Mendyfi WebPage:

Username: admin

Password: admin@1234

### - **ADDING USER/DOMAIN**

Add User / Domain

![Template](preview/admin_add_domain.png)


## - **RESTORE DATABASE**

Currently, you can manually restore the database using the console. I’m working on integrating it into the webpage.

```
docker compose run --rm artisan app:import-backup <YYYY-MM-DD>
```
Replace < YYYY-MM-DD > with the date you want to restore. e.g 2024-05-05

Modify the .env file to extend the number of days you want to keep backups.
```
DB_BACKUP_INTERVAL=7 #in Days
```

## - **TP-LINK EAP STANDALONE CONFIG**

You dont need a Controller for This Setup, Just a TP-LINK EAP AP and a Server that runs Mendyfi Radius

Check this Sample Config for your Guide: [Click Here](preview/tp-link.pdf)

## - **MIKROTIK CONFIG**

Check this Sample Config for your Guide: [Click Here](preview/mikrotik.pdf)

For Configuring Mikrotik to Use RADIUS: [Click Here](https://youtu.be/rgbyYfFOg6o?t=374)

## Buy me a Coffee

Donations are appreciated.

Paypal: https://paypal.me/RommelMendiola

GCash: 09553147435


