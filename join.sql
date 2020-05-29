use roby;

/*create view pplwithcountrieswithusrtype AS SELECT * FROM ppl left JOIN countries ON ppl.Nationality = countries.COUNTRY_ID;*/
create or replace view pplcountriesadmin as 
SELECT * FROM ppl 
JOIN countries 
ON ppl.Nationality=countries.COUNTRY_ID
JOIN user_roles
ON ppl.UsrType=user_roles.ID;