SET CLIENT_ENCODING TO UTF8;
SET STANDARD_CONFORMING_STRINGS TO ON;
BEGIN;
CREATE TABLE "agch_dcgw" (gid serial,
"area" numeric,
"perimeter" numeric,
"cov_" float8,
"cov_id" float8,
"idsnib" numeric,
"longitud" numeric,
"latitud" numeric,
"genero" varchar(254),
"especie" varchar(254),
"autorsp" varchar(254),
"aniosp" numeric,
"categinfra" varchar(254),
"nombreinfr" varchar(254),
"autorinfsp" varchar(254),
"anioinfsp" numeric,
"nombrecomu" varchar(254),
"estado" varchar(254),
"municipio" varchar(254),
"localidad" varchar(254),
"diacolecta" float8,
"mescolecta" float8,
"aniocolect" float8,
"ambiente" varchar(254),
"habitat" varchar(254),
"proyecto" varchar(254),
"nom059_10" varchar(50));
ALTER TABLE "agch_dcgw" ADD PRIMARY KEY (gid);
SELECT AddGeometryColumn('','agch_dcgw','geom','0','POINT',2);
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','8','9','114357.000000000','-92.600000','16.694444','Agave','chiapensis','Jacobi','1866.000000000','ND','ND','NA','9999.000000000','maguey chamula','Chiapas','San Cristobal de las Casas','Km 1189, entre San Cristobal de las Casas y Teopisca (coord. aprox.).','28','5','1969','ND','ND','P143','Sujeta a proteccion especial','0101000000A64B1CBE682657C06BC15BBAF8B13040');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','219','220','1330707.000000000','-92.638333','16.736667','Agave','chiapensis','Jacobi','1866.000000000','ND','ND','NA','9999.000000000','maguey chamula','Chiapas','San Cristobal de las Casas','SAN CRISTOBAL DE LAS CASAS','7','8','1984','Terrestre','BOSQUE MUY ALTERADO','Q017','Sujeta a proteccion especial','01010000006FB9B1CEDC2857C088665DB9C7BC3040');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','220','221','1330709.000000000','-92.475000','16.540000','Agave','chiapensis','Jacobi','1866.000000000','ND','ND','NA','9999.000000000','maguey chamula','Chiapas','Teopisca','TEOPISCA','28','5','1958','Terrestre','BOSQUE CLARO DE CUPRESSUS, SOBRE ROCAS','Q017','Sujeta a proteccion especial','0101000000CA73F5AF681E57C0E2AF1F906F8A3040');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','264','265','1632769.000000000','-92.563061','16.669439','Agave','chiapensis','Hort. Belg. ex Jacobi, 1866','9999.000000000','ND','ND','NA','9999.000000000','maguey chamula','Chiapas','San Cristobal de las Casas','Cerca de Rancho Nuevo, alrededor de 9 mi SE de San Cristobal de las Casas','20','8','1966','Terrestre','Steep slope near crest of ridge with Pinus, Quercus and Chiranthodendron','AE013','Sujeta a proteccion especial','0101000000DB2698840B2457C03E38041492AB3040');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','297','298','1776689.000000000','-96.017222','17.096944','Agave','chiapensis','Jacobi, 1866','9999.000000000','ND','ND','NA','9999.000000000','maguey chamula','Oaxaca','Santa Maria Tlahuitoltepec','Orilla del camino sobre una pena.','25','3','2002','Terrestre','Bosque de Pinus-Quercus','BC003','Sujeta a proteccion especial','01010000009946D3F81D0158C093DBB18901193140');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','298','299','1776690.000000000','-97.147222','17.643889','Agave','chiapensis','Jacobi, 1866','9999.000000000','ND','ND','NA','9999.000000000','maguey chamula','Oaxaca','Santiago Apoala','Canon de las Piedras Gemelas, 1 km, O, de Apoala.','11','6','2001','Terrestre','Matorral xerofilo perturbado con Quercus, Tillandsia, Agave angustiarum, A. aff. chiapensis, Malpighia y Annona','BC003','Sujeta a proteccion especial','0101000000FD186E62704958C03E962C6104A53140');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','300','301','1776797.000000000','-96.268056','17.150556','Agave','chiapensis','Jacobi, 1866','9999.000000000','ND','ND','NA','9999.000000000','maguey chamula','Oaxaca','Santo Domingo Xagacia','Cima del Cerro del Aguila, 4 km, S, de Xagacia.','3','2','1993','Terrestre','Bosque de Pinus-Quercus con Cercocarpus, Brahea y Agave','BC003','Sujeta a proteccion especial','01010000001ED375BE2B1158C03BE538DFBA263140');
INSERT INTO "agch_dcgw" ("area","perimeter","cov_","cov_id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","nom059_10",geom) VALUES ('0.00000','0.00000','304','305','1780166.000000000','-96.017194','17.097250','Agave','chiapensis','Jacobi, 1866','9999.000000000','ND','ND','NA','9999.000000000','maguey chamula','Oaxaca','Santa Maria Tlahuitoltepec','Rancho Tejas.','25','6','2004','Terrestre','Bosque Mixto, templado subhumedo','BC003','Sujeta a proteccion especial','0101000000B22162831D0158C07B12499715193140');
COMMIT;
