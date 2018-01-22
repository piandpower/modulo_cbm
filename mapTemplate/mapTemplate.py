#! /usr/bin/env python
# -*- coding: utf-8 -*-

#execfile(r"J:\USUARIOS\SISTEM\GMAGALLANES\template\maptemplate.py")
#Se instalo la biblioteca pygresql
# PyGreSQL-4.1.1.win32-py2.6-pg8.4.msi Esta es la version que se instalo, la que funciono. En Python/Arcgis10/  No instalar en otra direccion
# En la actualizacion se instalo: PyGreSQL-4.1.1.win32-py2.7-pg8.4.msi, en el directorio: C:\\Python27\ArcGis10.3  La baje de aqui: http://www.pygresql.org/files/


#############Script que anade una capa mas############

import arcpy
from arcpy import env
import os
import pg
import subprocess
#import re
########inicia conexion base de datos y query#################

#conn = pg.connect(dbname='metadatos', user='gmagallanes', passwd='gmagallanes-2016', host='172.16.1.179')

#conn = pg.connect(dbname='jm004', user='postgres', passwd='sig123456', host='200.12.166.29')
conn = pg.connect(dbname='distribucionJM034', user='postgres', passwd='sig123456', host='200.12.166.29')
#conn = pg.connect(dbname='sitiosJM034', user='postgres', passwd='sig123456', host='200.12.166.29')

########termina conexion base de datos y query#################

#lista_shapes = os.listdir(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\lyr_recolecta")
#lista_shapes = os.listdir(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\distribucionPotencial\\shp") #lista de shapes sin los demas archivos. SOLO SHAPES
#lista_shapes = os.listdir(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\sitiosDeRecolecta\\shp") #lista de shapes sin los demas archivos. SOLO shp

###########Aqui va la lista de shapes#################3







for shapefile in lista_shapes:

    filename, file_extension = os.path.splitext(shapefile)

    filename = filename.upper()

    consulta = "select nombre from coberturas where cobertura="+"'"+filename+"'"+""

    consulta_escala = "select escala from coberturas where cobertura="+"'"+filename+"'"+""
    consulta_publish = "select publish from coberturas where cobertura="+"'"+filename+"'"+""

    consulta_id = 'select "RECORD ID" as re from coberturas where cobertura='+"'"+filename+"'"+""

    consulta_fecha = 'select pubdate from coberturas where cobertura='+"'"+filename+"'"+""

    consulta_siglas = 'select publish_siglas from coberturas where cobertura='+"'"+filename+"'"+""

    resultado = conn.query(consulta)
    rows = resultado.namedresult()

    titulo_query = rows[0].nombre

    titulo_query = titulo_query.rstrip(".")

    titulo_shapeEstilo = titulo_query.split("(")

    #titulo_shapeEstilo[0]

    titulo_shape = "<CLR red='204' green='204' blue='204'><ita>"+titulo_shapeEstilo[0]+"</ita> ("+titulo_shapeEstilo[1]+"</CLR>"

    cita_shape = "<ita>"+titulo_query+"</ita>"


    titulo_shape = titulo_shape.replace("Distribución potencial actual", "")
    titulo_shape = titulo_shape.replace("Sitios de recolecta", "")



############3


    resultado_escala = conn.query(consulta_escala)
    rows_escala = resultado_escala.namedresult()
    escala_query = rows_escala[0].escala


    resultado_publish = conn.query(consulta_publish)
    rows_publish = resultado_publish.namedresult()
    publish_query = rows_publish[0].publish



    resultado_fecha = conn.query(consulta_fecha)
    rows_fecha = resultado_fecha.namedresult()
    fecha_query = rows_fecha[0].pubdate

    fecha = fecha_query.split('/')
    


    resultado_id = conn.query(consulta_id)
    rows_record_id = resultado_id.namedresult()
    record_query = rows_record_id[0].re

    record_query = str(record_query)

    autores = 'select origin from "Autores_origen" where "ID_origen"='+record_query+''
    resultado_id = conn.query(autores)
    autores_id = resultado_id.namedresult()


    siglas_id = conn.query(consulta_siglas)
    rows_siglas_id = siglas_id.namedresult()
    siglas_query = rows_siglas_id[0].publish_siglas

    if len(autores_id) == 1:
        if autores_id[0].origin.isupper():
            autores_query = autores_id[0].origin
        else:
            separadoXguion_1 = autores_id[0].origin.split("-")
    elif len(autores_id) == 2:
        separadoXguion_1 = autores_id[0].origin.split("-")
        separadoXguion_2 = autores_id[1].origin.split("-")
        autores_query = str(separadoXguion_1[0])+" y "+str(separadoXguion_2[0])
    elif len(autores_id) > 2:
        separadoXguion_1 = autores_id[0].origin.split("-")
        if "," in separadoXguion_1[0]:
            separadoXcoma = separadoXguion_1[0].split(",")
            autores_query = str(separadoXcoma[0])+" <FNT><ita>et al</ita></FNT>"
        else:
            autores_query = str(separadoXguion_1[0])+" <FNT><ita>et al</ita></FNT>"
    else:
   #     autores_query = "<CLR red='204' green='0' blue='0'>Revisa la Base de Datos</CLR>"
        autores_query = siglas_query
#####################333

    if len(autores_id) == 1:
        separadoXcoma = autores_id[0].origin.split(",")
  
        if len(separadoXcoma) > 1:
            autores_cita_1 = separadoXcoma[0].strip()
            autores_cita_2 = separadoXcoma[1].strip()
            cita = autores_cita_1+", "+autores_cita_2

        if len(separadoXcoma) == 1:

            autores_cita_1 = autores_id[0].origin

            cita = autores_cita_1+"."
            
    elif len(autores_id) > 1:
        separadoXcoma = autores_id[0].origin.split(",")
        separadoXpunto = autores_id[0].origin.split(".")

        if len(separadoXcoma) > 1:
            autores_cita_1 = separadoXcoma[0].strip()
            autores_cita_2 = separadoXcoma[1].strip()
            cita = autores_cita_1+", "+autores_cita_2+", "
  
            i = 1
            autores_cita = ""
            while i<len(autores_id):
                separadoXpunto = autores_id[i].origin.split(".")

                j = 1
                while j<=len(separadoXpunto):
                    autores_cita = autores_cita+ separadoXpunto[j-1]+"."
                    j+=1
                autores_cita = autores_cita.rstrip(".")
                autores_cita = autores_cita+"., "
                i+=1
            cita = cita + autores_cita.rstrip(", ")
    elif len(autores_id) == 0:
        cita = siglas_query
#        cita = "<CLR red='204' green='0' blue='0'>Revisa la Base de Datos</CLR>"


######################

#    cita = autores_query+". "+fecha[2]+". "+cita_shape+". "+escala_query+". "+publish_query 

    print cita_shape
    

    if type(escala_query) == type(None):
 
        cita1 = cita+" "+fecha[2]+". "+cita_shape+","   
        cita2 = "escala: "+"<CLR red='204' green='0' blue='0'>NULL</CLR>"+". "+publish_query+"." 
    else:

        cita1 = cita+" "+fecha[2]+". "+cita_shape+","   
        cita2 = "escala: "+escala_query+". "+publish_query+"." 



###############3

    mxd = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\baseSeptiembre3.mxd")   #mxds base  distribucion
    mxd_P = arcpy.mapping.MapDocument(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\BaseAgostoSR.mxd")   #mxds base sitios de recolecta

    df = arcpy.mapping.ListDataFrames(mxd)[0]
    df_P = arcpy.mapping.ListDataFrames(mxd_P)[0]
    
    #newlayer1 = arcpy.mapping.Layer(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\shp\\"+shapefile+"")
#    newlayer1 = arcpy.mapping.Layer(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\distribucionPotencial\\"+shapefile+"")
    #newlayer1 = arcpy.mapping.Layer(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\sitiosDeRecolecta\\"+shapefile+"")














    #desc = arcpy.Describe(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\shp\\"+shapefile+"")
    #desc = arcpy.Describe(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm022\\Cartografia_final\\Shapefile\\DistribucionPotencial\\"+shapefile+"")
#    desc = arcpy.Describe(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\distribucionPotencial\\"+shapefile+"")






#desc = arcpy.Describe(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\sitiosDeRecolecta\\"+shapefile+"")
    #print desc.shapeType 
    #print desc.featureType
    #print desc.datasetType
    print "Trabajando "+desc.file+". Espera por favor." 
    #print desc.dataElementType
    #print desc.baseName

    if desc.shapeType == "Polygon":

        #symbologyLayer = (r"C:\\Users\\CPR\\Desktop\\template\\base\\baseNew.lyr")
        #symbologyLayer = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\distPot.lyr")
#        symbologyLayer = (r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\distribucionPotencial\\septiembre.lyr")








        arcpy.ApplySymbologyFromLayer_management(newlayer1, symbologyLayer)
        arcpy.mapping.AddLayer(df, newlayer1, "AUTO_ARRANGE")

        for capa in arcpy.mapping.ListLayers(mxd, "", df):

            if capa.name == "dest_2010gw": 
                oldlayer = capa
            if capa.name == desc.baseName:
                newLayer = capa
        


        arcpy.mapping.MoveLayer(df, newLayer, oldlayer,  "BEFORE")

   
   #     arcpy.MakeFeatureLayer_management(r"C:\\Users\\CPR\\Desktop\\template\\base\\informacion_base\\dest_2010gw.shp", "dest_2010gw_lya")
   #     arcpy.MakeFeatureLayer_management(newlayer1, "capa_lya")
   #     arcpy.SelectLayerByLocation_management("dest_2010gw_lya","CONTAINS", newlayer1)




        ext = newlayer1.getExtent()
        df.extent = ext
        #df.zoomToSelectedFeatures()
    #    arcpy.Delete_management("dest_2010gw_lya")
      #  arcpy.Delete_management("capa_lya")


 #       arcpy.CopyFeatures_management("aaa","C:\\Users\\CPR\\Desktop\\template\\mientras\\aaa")
#        mxd.saveACopy(r"C:\\Users\\CPR\\Desktop\\template\\mxd\\"+filename+".mxd")
#        arcpy.RefreshActiveView()

        #df.newlayer1.getExtent().within("s","BOUNDARY")
        
#try:

#except:
 #   print(arcpy.GetMessages())
 #except Exception as err:
 #print(err, args[0])


        #arcpy.Intersect_analysis("dest_2010gw.shp", shapefile)

        #ext = newlayer1.getSelectionSet()
        #contains(r"C:\\Program Files (x86)\\ArcGIS\\Desktop10.0\\MapTemplates\\Plantillas\\Institucionales\\informacion_base\\dest_2010gw.shp")
        #ext = dest_2010gwh.getExtent()
        #mx = newlayer1.getSelectedExtent("ext")
        #df.extent = mx
        #df.extent.contains(r"C:\\Program Files (x86)\\ArcGIS\\Desktop10.0\\MapTemplates\\Plantillas\\Institucionales\\informacion_base\\dest_2010gw.shp")
#        df.extent.contains()
        #df.extent = hola.getSelectedExtent()
        #df.panToExtent(ext)
        #df.zoomToSelectedFeatures()
   #     arcpy.RefreshActiveView()


        for elm in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elm.text == 'titulo':
                elm.text = titulo_shape



        for fechaDp in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if fechaDp.text == 'subtitulo':
                fechaDp.text = "Distribución potencial actual ("+autores_query+", "+fecha[2]+")"






        for elmPie in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elmPie.text == 'cita1':
                elmPie.text = cita1


        for elmPie in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elmPie.text == 'cita2':
                elmPie.text = cita2



#    arcpy.RefreshActiveView()
#    arcpy.RefreshTOC()
        #existImage = os.path.isfile(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\fb\\"+filename+".jpg")
#        existImage = os.path.isfile(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Imagenes_especies\\distribucionPotencial\\"+filename+".jpg")











        if existImage == True:
            for img in arcpy.mapping.ListLayoutElements(mxd, "PICTURE_ELEMENT"):

#                img.sourceImage = (r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Imagenes_especies\\distribucionPotencial\\"+filename+".jpg")

                img.elementPositionX = 0.5082
                img.elementPositionY = 10.17
                img.elementWidth = 4.09

        logo = arcpy.mapping.ListLayoutElements(mxd, "PICTURE_ELEMENT")[0]

        logo.sourceImage = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\logo2012_2018.PNG")
        logo.elementPositionX = 0.5006
        logo.elementPositionY = 19.060
        logo.elementWidth = 2.0395
        logo.elementHeight = 2.02

        cc = arcpy.mapping.ListLayoutElements(mxd, "PICTURE_ELEMENT")[2]
    
        cc.sourceImage = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\cc.png")
        cc.elementPositionX = 24.44
        cc.elementPositionY = 0.6
        cc.elementWidth = 2.85
        cc.elementHeight = 0.99

        #mxd.saveACopy(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\mxd\\"+filename+".mxd")
        #mxd.saveACopy(r"C:\\Users\\slara\\Desktop\\dP\\mxd\\"+filename+".mxd")
#        mxd.saveACopy(r"C:\\Users\\ssocialsig.CONABIO\\Desktop\\test_mxd\\"+filename+".mxd")













#       mxd.save()

        #arcpy.mapping.ExportToPNG(mxd, r"C:\\Users\\ssocialsig.CONABIO\\Desktop\\"+filename+".png", resolution=300)
        #arcpy.mapping.ExportToPNG(mxd, r"C:\\Users\\slara\\Desktop\\dP\\png\\"+filename+".png", resolution=300)
#        arcpy.mapping.ExportToPNG(mxd, r"C:\\Users\\ssocialsig.CONABIO\\Desktop\\test_png\\"+filename+".png", resolution=300)










        for df in arcpy.mapping.ListDataFrames(mxd):
            for lyr in arcpy.mapping.ListLayers(mxd, "", df):
                if lyr.name == filename:        
                    arcpy.mapping.RemoveLayer(df, lyr)


        for elemento in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elemento.text == titulo_shape.decode('utf-8'):
                elemento.text = 'titulo'


        for fecha_Dp in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if fecha_Dp.text == "Sitios de recolecta ("+autores_query+", "+fecha[2]+")":
                fecha_Dp.text = 'subtitulo'

        for elementoPie in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elementoPie.text == cita1.decode('utf-8'):
                elementoPie.text = 'cita1'



        for elementoPie in arcpy.mapping.ListLayoutElements(mxd, "TEXT_ELEMENT"):
            if elementoPie.text == cita2.decode('utf-8'):
                elementoPie.text = 'cit2'



        arcpy.mapping.RemoveLayer(df, newlayer1)
#################################################################################
#                         Comienza la parte de puntos                           #
#################################################################################
    else:

        #symbologyLayer = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\basePuntos.lyr")
        #symbologyLayer = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\septiembreSr.lyr")
#        symbologyLayer = (r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Shapefile\\sitiosDeRecolecta\\septiembreSr.lyr")







        arcpy.ApplySymbologyFromLayer_management(newlayer1, symbologyLayer)
        arcpy.mapping.AddLayer(df_P, newlayer1, "AUTO_ARRANGE")

        ext = newlayer1.getExtent()

        df_P.extent = ext

        for elm in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elm.text == 'titulo':
                elm.text = titulo_shape




        for fechaDp in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if fechaDp.text == 'subtitulo':
                fechaDp.text = "Sitios de recolecta ("+autores_query+", "+fecha[2]+")"






        for elmPie in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elmPie.text == 'cita1':
                elmPie.text = cita1



        for elmPie in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elmPie.text == 'cita2':
                elmPie.text = cita2

#    arcpy.RefreshActiveView()
#    arcpy.RefreshTOC()

        #existImagep = os.path.isfile(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\fb\\"+filename+".jpg")
        #existImagep = os.path.isfile(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm022\\Cartografia_final\\imagenes_especies\\SitiosDeRecolecta\\"+filename+".jpg")
#        existImagep = os.path.isfile(r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\Imagenes_especies\\sitiosDeRecolecta\\"+filename+".jpg")






        if existImagep == True:
            for img in arcpy.mapping.ListLayoutElements(mxd_P, "PICTURE_ELEMENT"):
#                img.sourceImage = (r"J:\\USUARIOS\\SISTEM\\JMDAVILA\\Plantilla\\jm034\\Cartografia_final\\imagenes_especies\\sitiosDeRecolecta\\"+filename+".jpg")



                img.elementPositionX = 0.5082
                img.elementPositionY = 10.174
                img.elementWidth = 4.09

        #    for img in arcpy.mapping.ListLayoutElements(mxd, "PICTURE_ELEMENT"):

        logo = arcpy.mapping.ListLayoutElements(mxd_P, "PICTURE_ELEMENT")[0]

        logo.sourceImage = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\logo2012_2018.PNG")
        logo.elementPositionX = 0.5006
        logo.elementPositionY = 19.060
        logo.elementWidth = 2.0395
        logo.elementHeight = 2.02

        cc = arcpy.mapping.ListLayoutElements(mxd_P, "PICTURE_ELEMENT")[2]
    
        cc.sourceImage = (r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\base\\cc.png")
        cc.elementPositionX = 24.44
        cc.elementPositionY = 0.6
        cc.elementWidth = 2.85
        cc.elementHeight = 0.99

        #mxd_P.saveACopy(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\mxd\\"+filename+".mxd")
        #mxd_P.saveACopy(r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\mxd_recolecta\\"+filename+".mxd")
        #mxd_P.saveACopy(r"C:\\Users\\slara\\Desktop\\sR\\mxd\\"+filename+".mxd")
#        mxd_P.saveACopy(r"C:\\Users\\ssocialsig.CONABIO\\Desktop\\test_mxd\\"+filename+".mxd")









        #arcpy.mapping.ExportToPNG(mxd_P, r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\png\\"+filename+".png", resolution=300)
        #arcpy.mapping.ExportToPNG(mxd_P, r"J:\\USUARIOS\\SISTEM\\GMAGALLANES\\template\\png_recolecta\\"+filename+".png", resolution=300)

        #arcpy.mapping.ExportToPNG(mxd_P, r"C:\\Users\\slara\\Desktop\\sR\\png\\"+filename+".png", resolution=300)
#        arcpy.mapping.ExportToPNG(mxd_P, r"C:\\Users\\ssocialsig.CONABIO\\Desktop\\test_png\\"+filename+".png", resolution=300)











        for df_P in arcpy.mapping.ListDataFrames(mxd_P):
            for lyr in arcpy.mapping.ListLayers(mxd_P, "", df_P):
                if lyr.name == filename:        
                    arcpy.mapping.RemoveLayer(df_P, lyr)

        for elemento in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elemento.text == titulo_shape.decode('utf-8'):
                elemento.text = 'titulo'





        for fecha_Dp in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if fecha_Dp.text == "Sitios de recolecta ("+autores_query+", "+fecha[2]+")":
                fecha_Dp.text = 'subtitulo'







        for elementoPie in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elementoPie.text == cita1.decode('utf-8'):
                elementoPie.text = 'cita1'



        for elementoPie in arcpy.mapping.ListLayoutElements(mxd_P, "TEXT_ELEMENT"):
            if elementoPie.text == cita2.decode('utf-8'):
                elementoPie.text = 'cita2'

        arcpy.mapping.RemoveLayer(df_P, newlayer1)

################Fin script que anade una capa mas######################

conn.close()
