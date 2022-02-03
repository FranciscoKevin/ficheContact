# ficheContact
# Demonstration

With Loom: https://www.loom.com/share/eadca40eb7874e06918cb7fe713d02e7
# Installation

- Clone the Github repository.
- Run: `composer install`.
- Run: `yarn install`.
- Run `server:ca:install` for the SSL certificate in local.
- Create **DATABASE_URL**="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7" in your .env.local file.
- Run `composer prepare`.
- Run `symfony serv`.
- Run `yarn encore dev to build assets`.
- If you want to test sending email, **use mailtrap**: https://mailtrap.io/.
Edit your .env.local file in your project directory and set the **MAILER_DSN value** to configure **SMTP**.
