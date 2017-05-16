-- REPORT RESULT

-- Account/Contact that Ready to import
select DataSource, count(*) total from migration_contact GROUP By DataSource
union
select DataSource, count(*) total from migration_account GROUP By DataSource;









update migration_account
set name = UC_DELIMETER(name, '-', false) where name 
like '%-%' and a.id > '0';



update migration_contact
set lastname = UC_DELIMETER(lastname, '-', false) where lastname
like '%-%' and a.id > '0';



update migration_account
set name = UC_DELIMETER(name, '(', false) where name 
like '%(%' and id > '0';

update migration_account
set lastname = UC_DELIMETER(lastname, '(', false) where lastname 
like '%(%' and id > '0';