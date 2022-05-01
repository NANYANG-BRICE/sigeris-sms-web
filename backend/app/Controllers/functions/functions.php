
<?php  
	function generate_random_text(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $maxlength = strlen($caracteres);
        $result = '';
        for ($i = 0; $i < $length; $i++){
            $result .= $caracteres[rand(0, $maxlength - 1)];
        }
		return $result;
	}

	function generate_matricule(){
		$result = generate_matricule().'-'.rand(1000, 9999).'-'.generate_matricule().''.rand(1000, 9999);
		return $result;
	}

    function generer_token() {
        $length = rand(55, 75);
        $caracteres = 'aLABbC0cEd1eDf2FghR(3ij4kYXQl5UmOPn6pVq7rJs8tuW9IvGwxHTyKZMS';
        $maxlength = strlen($caracteres);
        $result = '';
        for ($i = 0; $i < $length; $i++){
            $result .= $caracteres[rand(0, $maxlength - 1)];
        }
        return $result;
    }

    function generer_code_activation(){
        $result = rand(10000000, 99999999);
        return $result;
    }
?>