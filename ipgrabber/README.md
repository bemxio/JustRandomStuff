# IP Grabber

an IP grabber that also gives geolocation,

i made it some months ago to test my PHP skills

## Table configuration

just make any table with 7 columns, all with `varchar(255)` datatype

and name the 1st column "ip"

if you're lazy just type this command in mysql:

`CREATE TABLE <table name> (ip varchar(16), city varchar(255), region varchar(255), country varchar(255), coords varchar(255), organization varchar(255), postal varchar(255));`
