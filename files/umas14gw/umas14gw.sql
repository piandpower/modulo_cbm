SET CLIENT_ENCODING TO UTF8;
SET STANDARD_CONFORMING_STRINGS TO ON;
BEGIN;
CREATE TABLE "umas14gw" (gid serial,
"nombre" varchar(254),
"clave" varchar(254),
"id_edo" numeric(10,0),
"municipio" varchar(254),
"superficie" numeric(10,0),
"id_uma" numeric,
"area" numeric,
"vigencia" varchar(254),
"cancelado" varchar(254),
"cov_" int2,
"cov_id" int4);
ALTER TABLE "umas14gw" ADD PRIMARY KEY (gid);
SELECT AddGeometryColumn('','umas14gw','geom','0','MULTIPOLYGON',2);
INSERT INTO "umas14gw" ("nombre","clave","id_edo","municipio","superficie","id_uma","area","vigencia","cancelado","cov_","cov_id",geom) VALUES ('Xalnene','DGVS-CR-EX-3146-TLAX','29','Atlangatepec','96','3.14600000000e+003','2.53280000000e+000','Indefinida','No','0','1','01060000000100000001030000000100000005000000E8363CA4DD8B58C0BA3CA3F1568933406640C19CE18B58C0195864B721893340E66F91C61C8C58C0E15BC65C338933407DB9E7E4E08B58C025747A526C893340E8363CA4DD8B58C0BA3CA3F156893340');
