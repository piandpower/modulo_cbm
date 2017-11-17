SET CLIENT_ENCODING TO UTF8;
SET STANDARD_CONFORMING_STRINGS TO ON;
BEGIN;
CREATE TABLE "anp2005cw" (gid serial,
"id" float8,
"idsnib" float8,
"longitud" float8,
"latitud" float8,
"genero" varchar(254),
"especie" varchar(254),
"autorsp" varchar(254),
"aniosp" varchar(254),
"categinfra" varchar(254),
"nombreinfr" varchar(254),
"autorinfsp" varchar(254),
"anioinfsp" varchar(254),
"nombrecomu" varchar(254),
"estado" varchar(254),
"municipio" varchar(254),
"localidad" varchar(254),
"diacolecta" int4,
"mescolecta" int4,
"aniocolect" int4,
"ambiente" varchar(254),
"habitat" varchar(254),
"proyecto" varchar(254),
"cov_" int2,
"cov_id" int2,
"nom059_10" varchar(50));
ALTER TABLE "anp2005cw" ADD PRIMARY KEY (gid);
SELECT AddGeometryColumn('','anp2005cw','geom','0','POINT',2);
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1364','186192','-109.577020','26.691580','Balaenoptera','musculus','Linnaeus','1758','Subespecie','musculus','Linnaeus','1758','ballena azul','Sonora','Huatabampo','Santa Barbara bahia','99','99','9999','Marino','Neritico Oceanico Pelagico','P104','1507','1508','Sujeta a proteccion especial','0101000000D4484BE5ED645BC053910A630BB13A40');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1365','41428','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1508','1509','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1366','41413','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1509','1510','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1367','41414','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1510','1511','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1368','41415','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1511','1512','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1369','41416','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1512','1513','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1370','41417','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1513','1514','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1371','186204','-114.803820','31.046270','Balaenoptera','musculus','Linnaeus','1758','Subespecie','musculus','Linnaeus','1758','ballena azul','Baja California','Mexicali','Punta El Machorro  Punta San Felipe','99','99','9999','Marino','NNeritico Oceanico Pelagico','P104','1514','1515','Sujeta a proteccion especial','0101000000BAF770C971B35CC032C9C859D80B3F40');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1372','41430','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1515','1516','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1373','41429','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1516','1517','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1374','41431','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1517','1518','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1375','186147','-109.916667','22.883333','Balaenoptera','musculus','Linnaeus','1758','Subespecie','musculus','Linnaeus','1758','ballena azul','Baja California Sur','Los Cabos','Cabo San Lucas','99','99','9999','Marino','Neritico Oceanico Pelagico','P104','1518','1519','Sujeta a proteccion especial','0101000000A39410ACAA7A5BC0427A8A1C22E23640');
INSERT INTO "anp2005cw" ("id","idsnib","longitud","latitud","genero","especie","autorsp","aniosp","categinfra","nombreinfr","autorinfsp","anioinfsp","nombrecomu","estado","municipio","localidad","diacolecta","mescolecta","aniocolect","ambiente","habitat","proyecto","cov_","cov_id","nom059_10",geom) VALUES ('1376','41432','-110.515400','24.189660','Balaenoptera','musculus','Linnaeus','1758','NA','NA','NA','NA','ballena azul','Baja California Sur','La Paz','Bahia de La Paz','99','99','9999','Marino','ND','P044','1519','1520','Sujeta a proteccion especial','0101000000F0164850FCA05BC0FF5BC98E8D303840');
COMMIT;
