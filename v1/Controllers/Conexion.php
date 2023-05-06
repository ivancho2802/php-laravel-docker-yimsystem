<?php

namespace Controllers;

class Conexion
{
	public function conectar()
	{
		//psql 'postgres://ings.ivandiaz:UDtVsYR6PG9c@ep-dry-resonance-197252.us-east-2.aws.neon.tech/neondb'
		//$conexion =  pg_connect("host=ec2-3-222-30-53.compute-1.amazonaws.com port=5432 dbname=d8dgaqfecs81l5 user=bbefneimvprfqo password=fdd8bcae207b03ec7f030d1f42b3c3b7234743f3208a3a022a6f523f35163c94") ;
		// $conexion = new mysqli("ec2-107-20-155-148.compute-1.amazonaws.com", "kjogxhvdvnkumx", "b42f2b9f3dda672e63925904f1450b38698f03289409be8008efd07f526c20a9", "delcqdglr7h1b8", 5432);
		//$conexion =  pg_connect("host=ec2-107-20-155-148.compute-1.amazonaws.com port=5432 dbname=delcqdglr7h1b8 user=kjogxhvdvnkumx password=b42f2b9f3dda672e63925904f1450b38698f03289409be8008efd07f526c20a9") ;
		//$conexion =  pg_connect("host=ec2-54-86-170-8.compute-1.amazonaws.com port=5432 dbname=d1ffioj5igskat user=nnogiraqfwogcp password=520027befc2d0ea9adc42f7f9a304c4ac4e202018532495c0417e26d4ef94d8e") ;
		// $conexion = new mysqli("localhost", "root", "", "panaderia");

		$endpointId = "ep-dry-resonance-197252";
		$host = "us-east-2.aws.neon.tech";
		$port = "5432";
		$dbname = "neondb";
		$user = "ings.ivandiaz";
		$password = "UDtVsYR6PG9c";
		$conexion = pg_connect(
			"host=".$host.
			" options='project=".$endpointId.
			"' port=".$port.
			" dbname=".$dbname.
			" user=".$user.
			" password=".
			$password." sslmode=require"
		);

		if (!$conexion) {
			var_dump($conexion);
			die("Connection failed: " );
		} else {
			return $conexion;
		}

	}
}