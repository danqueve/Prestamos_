<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<style type="text/css">
span{	
	font-size:14px; padding:10px; color: #666666}
	#tr1{ height:50px;}
	#table1{ border-radius:7px; border:none}
</style>
</head>
<body>
<table id="table1" align="center"  bgcolor="#999999" ><tr id="tr1"><td><DIV id=head_menu>
<UL class=menu>
 <LI class="parent item2"><A 
  ><SPAN>CLIENTES</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="nuevocliente.php"><SPAN>NUEVO</SPAN></A></LI>
        <LI class=item107><A 
    href="buscarclientes.php"><SPAN>BUSCAR</SPAN></A></LI>  <LI class=item107><A 
    href="situacion.php"><SPAN>SITUACION</SPAN></A></LI>
  </UL>
  </LI>   
  <LI class="parent item2"><A 
  ><SPAN>PRESTAMOS</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="nuevoprestamo.php"><SPAN>NUEVO</SPAN></A></LI>
       <LI class=item107><A 
    href="buscarprestamosf.php"><SPAN>BUSCAR</SPAN></A></LI>
     <LI class=item107><A 
    href="cancelados.php"><SPAN>PRESTAMOS CANCELADOS</SPAN></A></LI>
     <LI class=item107><A 
    href="buscarcuotasadeudadas.php"><SPAN>BUSCAR CUOTAS ADEUDADAS</SPAN></A></LI>
    <LI class=item107><A 
    href="buscarcuotasvencidas.php"><SPAN>BUSCAR CUOTAS VENCIDAS</SPAN></A></LI>
   
  </UL>
  </LI>
   
   <LI class="parent item2"><A 
  ><SPAN>COBROS</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="nuevocobro.php"><SPAN>COBRAR CUOTAS</SPAN></A></LI> 
     
     <LI class=item107><A 
    href="cancelar.php"><SPAN>COBRAR PRESTAMO COMPLETO</SPAN></A></LI>
    
         <LI class=item107><A 
    href="buscarcobrosf.php"><SPAN>BUSCAR</SPAN></A></LI>
  
  </UL>
  </LI>
  
  <? if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
  
    <LI class="parent item2"><A 
  ><SPAN>COBROS LIBRES</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="nuevocobro22.php"><SPAN>NUEVO COBRO LIBRE</SPAN></A></LI> 
      <LI class=item107><A 
    href="vercobrosf.php"><SPAN>VER COBROS LIBRES</SPAN></A></LI>
    <LI class=item107><A 
    href="vercobrosa.php"><SPAN>VER COBROS LIBRES ANULADOS</SPAN></A></LI>
  </UL>
  </LI>
  
    <LI class="parent item2"><A 
  ><SPAN>PAGOS</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="nuevopago.php"><SPAN>NUEVO PAGO</SPAN></A></LI> 
      <LI class=item107><A 
    href="verpagos.php"><SPAN>VER PAGOS</SPAN></A></LI>
    <LI class=item107><A 
    href="verpagosa.php"><SPAN>VER PAGOS ANULADOS</SPAN></A></LI>
  </UL>
  </LI>
    <LI class="parent item2"><A 
  ><SPAN>CAJA</SPAN></A>
   <UL>
    <LI class=item107><A 
    href="buscarcajaf.php"><SPAN>VER CAJA</SPAN></A></LI> 
     
  </UL>
  </LI>
     <? } ?>
       
         <LI class="parent item3"><A 
  ><SPAN>AYUDA</SPAN></A>
  <UL>  
 <? if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
       
          <LI class=item107><A 
    href="nuevousuario.php"><SPAN>NUEVO USUARIO</SPAN></A></LI> 
    <LI class=item107><A 
    href="buscarusuarios.php"><SPAN>BUSCAR USUARIOS</SPAN></A></LI> 
    <LI class=item107><A 
    href="modificarinteres.php"><SPAN>MODIFICAR INTERES</SPAN></A></LI> 
   
          <LI class=item107><A 
    href="cambiarclave.php"><SPAN>CAMBIAR CLAVE DE SISTEMA</SPAN></A></LI> 
      
                 <LI class=item91><A 
    ><SPAN>DESARROLLADO PARA MOHAMED</SPAN></A></LI>
    <? } ?>
         <LI class=item91><A href="cerrarsesion.php"
    ><SPAN>CERRAR SESION</SPAN></A></LI>
    </UL></LI>
  
 
</UL></DIV></td></tr></table>
</body>
</html>
