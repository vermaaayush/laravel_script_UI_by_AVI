<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;


class IvrLanguageController extends Controller
{
	
		
	public function index($language,$index){
		
		
		$Array['en-AU'] = [
		'handle1' =>'If you have your Telephone Bank login details or ATM Debit Card Number Press 1',
		'handle2' =>'To Speak to Customer Care support press 2.',
		'handle3' =>'Please enter your CUSTOMER I D followed by the Pound key',
		'handle4' =>'Your call is being transfered. Please wait while i connect you.',
		'handle5' =>'Hello, Thank you for calling the Customer Care service of',
		'handle6' =>'Please kindly enter The extention number of the department you are trying to reach',
		'handle7' =>"if you doesn't have the extension number, Please stay on the line to be connected to the next available operator",
		'handle8' =>'Please note that this call may be monitored for quality and training purposes',
		'handle9' =>'A Customer Agent will be with you shortly. please hold',
		'handle10' =>'Sorry, I didnt get your CUSTOMER I D',
		'handle11' =>'A Customer representative will be with you shortly. please hold',
		'handle12' => 'Your Input is invalid',
		'handle_map1'=>"if you doesn't have extension so please stay on the line to be connected to the next available operator",
		
		'handle_map'=>"Sorry we can not find the extention Number you entered, please try again with a valid extention number",
		'handle_map2'=>'Kindly enter the Extention Number Again',
		
		'customer_id_login1'=>'Enter your USER I D followed by the Pound key.',
		'customer_id_login2'=>"Sorry, I didn't get your USER I D",
		'customer_id_login3'=>'The CUSTOMER I D is invalid',
		'customer_id_login4'=>'Please re-enter your CUSTOMER I D followed by the Pound key',
		
		'user_id_login1'=>'Please enter your personal SECRET PIN, followed by the Pound key',
		'user_id_login2'=>"Sorry, I didn't get your SECRET PIN.",
		'user_id_login4'=>'The USER I D you enter is invalid.',	
		'user_id_login5'=>'Please re-enter your USER I D, followed by the Pound key',
		
		'pin_login1'=>'Sorry Your Account is blocked  Please Contact Customer Support! Thanks',
		'pin_login2'=>'Welcome back',
		'pin_login3'=>'To check your Account Balance, press 1',
		'pin_login4'=>'For online Transfer requests, press 2',
		'pin_login5'=>'press 4 to listen to you last 5 transactions',
		'pin_login6'=>'press 5 to check account status',
		'pin_login7'=>'For credit, press 6',
		'pin_login8'=>'To listen your messages, press 3',
		'pin_login10'=>'Please re-enter your PERSONAL SECRET PIN, followed by the Pound key',
		'pin_login11'=>'The SECRET PIN you entered is invalid',
		'pin_login12'=>'You have ',
		'pin_login13'=>'messages in your inbox.',
		
		'Welcome_user2'=>"Sorry, I didn't get your ACCOUNT NUMBER.",
		'Welcome_user3'=>'Please enter your ACCOUNT NUMBER followed by the Pound key.',
		
		'Welcome_user4'=>'To make a local transfer, press 1',
		'Welcome_user5'=>'To make a transfer to another bank, press 2',
		'Welcome_user6'=>'To go back to the MAIN MENU, press the star key',
		
		'Welcome_user7'=>'for credit limit, press 1',

		'Welcome_user8'=>'for credit transfer, press 2',
		'Welcome_user9'=>'To link a credit card account, press 3',
		
		'Welcome_user11'=>'To delete all message, press 2',
		'Welcome_user12'=>'your input is invalid, please enter a valid input',
		'Welcome_user13'=>'To pay Bills online and other special Account feature, press 3',

		'Welcome_user14'=>'you listen message number',
		'Welcome_user15'=>'Your status is Pending',
		'Welcome_user16'=>'Your status is Approved',
		'Welcome_user17'=>'Your status is Suspended',
		'accout_balance_login1'=>'Last Five Transactions  Details for this your account',
		'accout_balance_login2'=>'To listen to your Transactions  again press star To go back to your main Account Menu press 1',
		'accout_balance_login3'=>' Type of Account:',
		'accout_balance_login4'=>'Your Account Balance is',
		
		'accout_balance_login5'=>' To listen to your Account balance again press star To go back to your main Account Menu press 1',
		'accout_balance_login6'=>'The Account Number you entered is invalid',
		'accout_balance_login7'=>'Please re-enter your Account Number',

		'accout_balance_login8'=>'You have entered an invalid Input',
		'transfer_type1'=>'Please note for security reasons, you can only transfer to a saved linked account.',
		'transfer_type2'=>'You currently have no saved linked "Local Accounts". Please visit your nearest branch to link an account, to make a local transfer.',  
		'transfer_type3'=>'To select an Account to make your transfer, press the star key',

		'credit_process1'=>'Your Credit account balance is',
		'credit_process2'=>'To further process please choose from main menu.',
		'credit_process3'=>'You have no credit account linked.',
		'credit_process4'=>'To Link your credit account Please choose from main menu.',
		'credit_process5'=>'In Order to make a transfer the Credit Card must be linked, to listen to the available linked cards press 1',
		'credit_process6'=>'To receive request by mail press 1, To receive request by email press 2',

		'credit_process01'=>'You have the following cards linked,',
		'credit_process02'=>'you have a',
		'credit_process03'=>'Please Enter the last 6 digits on the credit card',
		'credit_process04'=>'This card account belongs to',
		'credit_process05'=>'Please enter amount',
		'credit_process06'=>'You Pushed',
	    'credit_process07'=>'This information entered is not valid, please re enter the 6 digits',
		'credit_process07'=>'Please enter token',
		'credit_process08'=>'Your transfer has been initiated. Give 12 to 24 hours for completion',

		'credit_process001'=>'Amount is greater than your remaining amount please re enter new amount',
		'credit_process002'=>'Request form has been sent to the address on file Thank you',
 	  'credit_process003'=>'Email is not working',
 	  'credit_process004'=>'Request Form has been sent to the email address on file Thank you',

 	  'transfer_acc_amount1'=>'This registered Account details belongs to',
 	  'transfer_acc_amount2'=>'Please enter the Amount to transfer followed by the Pound key.',
 	  'transfer_acc_amount3'=>'The Routing Number you entered is invalid.',
 	  'transfer_acc_amount4'=>'Please re-enter the Routing Number, followed by the Pound key',
 	  
 	  'transfer_token1'=>'Amount Accepted',
 	  'transfer_token2'=>'You have requested to transfer the sum of',
 	 'transfer_token3'=>'Please Enter your 5 digit "SECRET TRANSFER TOKEN CODE" followed by the Pound key.',
 	 'transfer_token4'=>'Amount not accepted due to insufficent Balance',
 	 'transfer_token5'=>'Please Enter a Valid AMOUNT followed by the Pound key',
 	 'transfer_link_acc1'=>'You have three registered linked accounts',
 	 'transfer_link_acc2'=>'To make a transfer to press 1',
 	 'transfer_link_acc3'=>'To make a transfer to press 2',
 	 'transfer_link_acc4'=>'To make a transfer to press 3',
 	 'transfer_acc_sort1'=>'Enter the Routing Number, followed by the Pound key',
 	 'transfer_acc_sort2'=>"Sorry, I didn't get the Routing Number.",
 	  'transfer_acc_sort3'=>"This Account Number is not linked for transfer.",
 	  'transfer_acc_sort4'=>"Please re-enter a registered linked Account Number, followed by the Pound key",		
 	  'transfer_credit1'=>"To go back to the main menu, press 1",
	 'transfer_credit2'=>"To exit, Please hang-up. Thank you.",
	  'transfer_credit3'=>", your transfer request has been accepted to",
	  'transfer_credit4'=>"The sum of will be debited from your Account.",
	  'transfer_credit5'=>"Your new account balance is",
	   'transfer_credit6'=>"Please allow about 1 to 2 business days for your transfer to take full effect.",
	   'transfer_credit7'=>"You have entered an invalid Transfer Token code.",
	   'transfer_credit8'=>'Please Enter your 5 digit "SECRET TRANSFER TOKEN CODE" followed by the Pound key.',
 
	   'transfer_credit9'=>"Sorry, I didn't get your TRANSFER TOKEN CODE",
		'dontGetResponse' => "Sorry, I didn't get your response",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",

		];
		
		$Array['es'] = [
		'handle1' =>'Si tiene los datos de inicio de sesión de Telephone Bank o el número de tarjeta de débito de ATM, presione 1.',
		'handle2' =>'Para hablar con el servicio de atención al cliente, presione 2.',
		'handle3' =>'Ingrese su ID de CLIENTE seguido de la tecla numeral',
		'handle4' => 'Su llamada está siendo transferida. Espere mientras lo conecto.',
		'handle5' =>'Hola, Gracias por llamar al servicio de Atención al Cliente de',
		'handle6' =>'Por favor, ingrese el número de extensión del departamento al que está tratando de comunicarse',
		'handle7' =>"Si no tiene el número de extensión, permanezca en la línea para conectarse con el siguiente operador disponible.",
		'handle8' =>'Tenga en cuenta que esta llamada puede ser monitoreada por motivos de calidad y capacitación.',
		'handle9' =>'Un agente del cliente estará con usted en breve. por favor espera',
		'handle10' =>'Lo siento, no obtuve su ID DE CLIENTE',
		'handle11' =>'Un representante del cliente estará con usted en breve. por favor espera',
		'handle12' => 'Tu entrada no es válida',
		'handle_map1'=>"Si no tiene extensión, permanezca en la línea para conectarse con el siguiente operador disponible.",
		
		'handle_map'=>"Lo sentimos, no podemos encontrar el número de extensión que ingresó. Vuelva a intentarlo con un número de extensión válido.",
		'handle_map2'=>'Por favor ingrese el número de extensión nuevamente',
		
		'customer_id_login1'=>'Ingrese su USUARIO I D seguida de la tecla Pound.',
		'customer_id_login2'=>"Lo siento, no obtuve tu USER I D",
		'customer_id_login3'=>'La CLIENTE I D no es válida',
		'customer_id_login4'=>'Vuelva a ingresar su ID de CLIENTE seguido de la tecla numeral',
		
		'user_id_login1'=>'Ingrese su PIN SECRETO personal, seguido de la tecla numeral',
		'user_id_login2'=>"Lo siento, no recibí tu PIN SECRETO.",
		'user_id_login4'=>'El ID DE USUARIO que ingresa no es válido.',	
		'user_id_login5'=>'Vuelva a ingresar su ID DE USUARIO, seguido de la tecla de almohadilla',
		
		'pin_login1'=>'Lo sentimos, su cuenta está bloqueada. Póngase en contacto con el servicio de atención al cliente. Gracias',
		'pin_login2'=>'Dar una buena acogida',
		'pin_login3'=>'Para verificar el saldo de su cuenta, presione 1',
		'pin_login4'=>'Para solicitudes de transferencia en línea, presione 2',
		'pin_login5'=>'presione 4 para escuchar sus últimas 5 transacciones',
		'pin_login6'=>'presione 5 para verificar el estado de la cuenta',
		'pin_login7'=>'Para crédito, presione 6',
		'pin_login8'=>'Para escuchar sus mensajes, presione 3',
		'pin_login10'=>'Vuelva a ingresar su PIN SECRETO PERSONAL, seguido de la tecla numeral',
		'pin_login11'=>'El PIN SECRETO que ingresaste no es válido',
		'pin_login12'=>'Tienes',
		'pin_login13'=>'mensajes en su bandeja de entrada.',
		
		'Welcome_user2'=>"Lo siento, no obtuve su NÚMERO DE CUENTA.",
		'Welcome_user3'=>'Ingrese su NÚMERO DE CUENTA seguido de la tecla numeral.',
		'Welcome_user4'=>'Para hacer una transferencia local, presione 1',
		'Welcome_user5'=>'Para realizar una transferencia a otro banco, presione 2',
		'Welcome_user6'=>'Para volver al MENÚ PRINCIPAL, presione la tecla asterisco',
		'Welcome_user7'=>'para límite de crédito, presione 1',
		
		'Welcome_user9'=>'Para vincular una cuenta de tarjeta de crédito, presione 3',
	
		'Welcome_user11'=>'Para borrar todos los mensajes, presione 2',
		'Welcome_user12'=>'su entrada no es válida, por favor ingrese una entrada válida',
		'Welcome_user13'=>'Para pagar facturas en línea y otras funciones especiales de la cuenta, presione 3',

		'accout_balance_login1'=>'Detalles de las últimas cinco transacciones para esta cuenta',
		'accout_balance_login2'=>'Para escuchar sus Transacciones nuevamente, presione asterisco Para volver al menú principal de su cuenta presione 1',
		'accout_balance_login3'=>' Tipo de cuenta:',
		'accout_balance_login4'=>'El saldo de su cuenta es',
		'accout_balance_login5'=>'Para volver a escuchar el saldo de su cuenta, presione asterisco. Para volver al menú principal de su cuenta, presione 1.',
		'accout_balance_login6'=>'El número de cuenta que ingresó no es válido',
		'accout_balance_login7'=>'Vuelva a ingresar su número de cuenta',

		'transfer_type1'=>'Tenga en cuenta que, por razones de seguridad, solo puede transferir a una cuenta vinculada guardada.',
		'transfer_type2'=>'Actualmente no tiene "cuentas locales" vinculadas guardadas. Visite la sucursal más cercana para vincular una cuenta y realizar una transferencia local.',  
		'transfer_type3'=>'Para seleccionar una cuenta para hacer su transferencia, presione la tecla asterisco',

		'credit_process1'=>'El saldo de su cuenta de crédito es',
		'credit_process2'=>'Para continuar con el proceso, elija del menú principal.',
		'credit_process3'=>'No tiene ninguna cuenta de crédito vinculada.',
		'credit_process4'=>'Para vincular su cuenta de crédito, elija del menú principal.',
		'credit_process5'=>'Para realizar una transferencia, la Tarjeta de Crédito debe estar vinculada, para escuchar las tarjetas vinculadas disponibles presione 1',
		'credit_process6'=>'Para recibir la solicitud por correo, presione 1, Para recibir la solicitud por correo electrónico, presione 2',

		'credit_process01'=>'Tienes las siguientes tarjetas vinculadas,',
		'credit_process02'=>'usted tiene un',
		'credit_process03'=>'Ingrese los últimos 6 dígitos de la tarjeta de crédito',
		'credit_process04'=>'Esta cuenta de tarjeta pertenece a',
		'credit_process05'=>'Por favor ingrese la cantidad',
		'credit_process06'=>'Empujaste',
	    'credit_process07'=>'Esta información ingresada no es válida, vuelva a ingresar los 6 dígitos',
		'credit_process07'=>'Por favor ingrese el token',
		'credit_process08'=>'Se ha iniciado tu transferencia. Dar de 12 a 24 horas para completar',

		'credit_process001'=>'El monto es mayor que el monto restante, vuelva a ingresar el nuevo monto',
		'credit_process002'=>'El formulario de solicitud ha sido enviado a la dirección registrada Gracias',
 	  'credit_process003'=>'El correo electrónico no funciona',
 	  'credit_process004'=>'El formulario de solicitud ha sido enviado a la dirección de correo electrónico registrada Gracias',

 	  'transfer_acc_amount1'=>'Los datos de esta cuenta registrada pertenecen a',
 	  'transfer_acc_amount2'=>'Ingrese el monto a transferir seguido de la tecla numeral.',
 	  'transfer_acc_amount3'=>'El número de ruta que ingresó no es válido.',
 	  'transfer_acc_amount4'=>'Vuelva a ingresar el número de ruta, seguido de la tecla numeral',
 	  
 	  'transfer_token1'=>'Cantidad aceptada',
 	  'transfer_token2'=>'Ha solicitado transferir la suma de',
 	 'transfer_token3'=>'Ingrese su "CÓDIGO SECRETO DE FICHA DE TRANSFERENCIA" de 5 dígitos seguido de la tecla numeral.',
 	 'transfer_token4'=>'Importe no aceptado debido a saldo insuficiente',
 	 'transfer_token5'=>'Ingrese una CANTIDAD válida seguida de la tecla numeral',
 	 'transfer_link_acc1'=>'Tienes tres cuentas vinculadas registradas',
 	 'transfer_link_acc2'=>'Para hacer una transferencia presione 1',
 	 'transfer_link_acc3'=>'Para hacer una transferencia, presione 2',
 	 'transfer_link_acc4'=>'To make a transfer to press 3',
 	 'transfer_acc_sort1'=>'Ingrese el número de ruta, seguido de la tecla numeral',
 	 'transfer_acc_sort2'=>"Lo siento, no obtuve el número de ruta.",
 	  'transfer_acc_sort3'=>"Este número de cuenta no está vinculado para transferencia.",
 	  'transfer_acc_sort4'=>"Vuelva a ingresar un número de cuenta vinculado registrado, seguido de la tecla numeral",		
 	  'transfer_credit1'=>"Para volver al menú principal, presione 1",
	 'transfer_credit2'=>"Para salir, cuelgue. Gracias.",
	  'transfer_credit3'=>",su solicitud de transferencia ha sido aceptada",
	  'transfer_credit4'=>"La suma de se debitará de su cuenta.",
	  'transfer_credit5'=>"El saldo de su nueva cuenta es",
	   'transfer_credit6'=>"Por favor, espere entre 1 y 2 días hábiles para que su transferencia entre en vigencia.",
	   'transfer_credit7'=>"Ha introducido un código de Token de transferencia no válido.",
	   'transfer_credit8'=>'Ingrese su "CÓDIGO SECRETO DE FICHA DE TRANSFERENCIA" de 5 dígitos seguido de la tecla numeral.',
 
	   'transfer_credit9'=>"Lo siento, no recibí tu CÓDIGO DE TRANSFERENCIA DE TOKEN",
		'dontGetResponse' => 'Lo siento, no me dieron',
		'ExceedLimit' => "Has excedido tu límite de tiempo muerto. Adiós.",
		];
		
		$Array['fr-FR'] = [
		'handle1' =>'Si vous avez vos coordonnées bancaires téléphoniques ou votre numéro de carte de débit ATM, appuyez sur 1',
		'handle2' =>'Pour parler au support client, appuyez sur 2.',
		'handle3' =>'Veuillez saisir votre CLIENT I D suivi de la touche Dièse',
		'handle4' =>'Votre appel est en cours de transfert. Veuillez patienter pendant que je vous connecte.',
		'handle5' =>"Bonjour, Merci d'avoir appelé le service client de",
		'handle6' =>"Veuillez entrer le numéro de poste du département que vous essayez d'atteindr",
		'handle7' =>"si vous n'avez pas le numéro de poste, veuillez rester en ligne pour être connecté au prochain opérateur disponible",
		'handle8' =>'Veuillez noter que cet appel peut être surveillé à des fins de qualité et de formation',
		'handle9' => 'Un agent client sera avec vous sous peu. attendez svp',
		'handle10' =>"Désolé, je n'ai pas obtenu votre CLIENT I D",
		'handle11' =>'Un représentant client sera avec vous sous peu. attendez svp',
		'handle12' => 'Votre entrée est invalide',
		'handle_map1'=>"si vous n'avez pas d'extension, veuillez rester en ligne pour vous connecter au prochain opérateur disponible",
		
		'handle_map'=>"Désolé, nous ne trouvons pas le numéro d'extension que vous avez entré, veuillez réessayer avec un numéro d'extension valide",
		'handle_map2'=>'Veuillez saisir à nouveau le numéro de poste',
		
		'customer_id_login1'=>'Enter your USER I D followed by the Pound key.',
		'customer_id_login2'=>"Sorry, I didn't get your USER I D",
		'customer_id_login3'=>'The CUSTOMER I D is invalid',
		'customer_id_login4'=>'Please re-enter your CUSTOMER I D followed by the Pound key',
		
		'user_id_login1'=>'Please enter your personal SECRET PIN, followed by the Pound key',
		'user_id_login2'=>"Sorry, I didn't get your SECRET PIN.",
		'user_id_login4'=>'The USER I D you enter is invalid.',	
		'user_id_login5'=>'Please re-enter your USER I D, followed by the Pound key',
		
		'pin_login1'=>'Sorry Your Account is blocked  Please Contact Customer Support! Thanks',
		'pin_login2'=>'Welcome back',
		'pin_login3'=>'To check your Account Balance, press 1',
		'pin_login4'=>'For online Transfer requests, press 2',
		'pin_login5'=>'press 4 to listen to you last 5 transactions',
		'pin_login6'=>'press 5 to check account status',
		'pin_login7'=>'For credit, press 6',
		'pin_login8'=>'To listen your messages, press 3',
		'pin_login10'=>'Please re-enter your PERSONAL SECRET PIN, followed by the Pound key',
		'pin_login11'=>'The SECRET PIN you entered is invalid',
		'pin_login12'=>'You have ',
		'pin_login13'=>'messages in your inbox.',
		
		'Welcome_user2'=>"Sorry, I didn't get your ACCOUNT NUMBER.",
		'Welcome_user3'=>'Please enter your ACCOUNT NUMBER followed by the Pound key.',
		
		'Welcome_user4'=>'To make a local transfer, press 1',
		'Welcome_user5'=>'To make a transfer to another bank, press 2',
		'Welcome_user6'=>'To go back to the MAIN MENU, press the star key',
		
		'Welcome_user7'=>'for credit limit, press 1',

		'Welcome_user8'=>'for credit transfer, press 2',
		'Welcome_user9'=>'To link a credit card account, press 3',
		
		'Welcome_user11'=>'To delete all message, press 2',
		'Welcome_user12'=>'your input is invalid, please enter a valid input',
		'Welcome_user13'=>'To pay Bills online and other special Account feature, press 3',

		'Welcome_user14'=>'you listen message number',
		'Welcome_user15'=>'Your status is Pending',
		'Welcome_user16'=>'Your status is Approved',
		'Welcome_user17'=>'Your status is Suspended',
		'accout_balance_login1'=>'Last Five Transactions  Details for this your account',
		'accout_balance_login2'=>'To listen to your Transactions  again press star To go back to your main Account Menu press 1',
		'accout_balance_login3'=>' Type of Account:',
		'accout_balance_login4'=>'Your Account Balance is',
		
		'accout_balance_login5'=>' To listen to your Account balance again press star To go back to your main Account Menu press 1',
		'accout_balance_login6'=>'The Account Number you entered is invalid',
		'accout_balance_login7'=>'Please re-enter your Account Number',

		'accout_balance_login8'=>'You have entered an invalid Input',
		'transfer_type1'=>'Please note for security reasons, you can only transfer to a saved linked account.',
		'transfer_type2'=>'You currently have no saved linked "Local Accounts". Please visit your nearest branch to link an account, to make a local transfer.',  
		'transfer_type3'=>'To select an Account to make your transfer, press the star key',

		'credit_process1'=>'Your Credit account balance is',
		'credit_process2'=>'To further process please choose from main menu.',
		'credit_process3'=>'You have no credit account linked.',
		'credit_process4'=>'To Link your credit account Please choose from main menu.',
		'credit_process5'=>'In Order to make a transfer the Credit Card must be linked, to listen to the available linked cards press 1',
		'credit_process6'=>'To receive request by mail press 1, To receive request by email press 2',

		'credit_process01'=>'You have the following cards linked,',
		'credit_process02'=>'you have a',
		'credit_process03'=>'Please Enter the last 6 digits on the credit card',
		'credit_process04'=>'This card account belongs to',
		'credit_process05'=>'Please enter amount',
		'credit_process06'=>'You Pushed',
	    'credit_process07'=>'This information entered is not valid, please re enter the 6 digits',
		'credit_process07'=>'Please enter token',
		'credit_process08'=>'Your transfer has been initiated. Give 12 to 24 hours for completion',

		'credit_process001'=>'Amount is greater than your remaining amount please re enter new amount',
		'credit_process002'=>'Request form has been sent to the address on file Thank you',
 	  'credit_process003'=>'Email is not working',
 	  'credit_process004'=>'Request Form has been sent to the email address on file Thank you',

 	  'transfer_acc_amount1'=>'This registered Account details belongs to',
 	  'transfer_acc_amount2'=>'Please enter the Amount to transfer followed by the Pound key.',
 	  'transfer_acc_amount3'=>'The Routing Number you entered is invalid.',
 	  'transfer_acc_amount4'=>'Please re-enter the Routing Number, followed by the Pound key',
 	  
 	  'transfer_token1'=>'Amount Accepted',
 	  'transfer_token2'=>'You have requested to transfer the sum of',
 	 'transfer_token3'=>'Please Enter your 5 digit "SECRET TRANSFER TOKEN CODE" followed by the Pound key.',
 	 'transfer_token4'=>'Amount not accepted due to insufficent Balance',
 	 'transfer_token5'=>'Please Enter a Valid AMOUNT followed by the Pound key',
 	 'transfer_link_acc1'=>'You have three registered linked accounts',
 	 'transfer_link_acc2'=>'To make a transfer to press 1',
 	 'transfer_link_acc3'=>'To make a transfer to press 2',
 	 'transfer_link_acc4'=>'To make a transfer to press 3',
 	 'transfer_acc_sort1'=>'Enter the Routing Number, followed by the Pound key',
 	 'transfer_acc_sort2'=>"Sorry, I didn't get the Routing Number.",
 	  'transfer_acc_sort3'=>"This Account Number is not linked for transfer.",
 	  'transfer_acc_sort4'=>"Please re-enter a registered linked Account Number, followed by the Pound key",		
 	  'transfer_credit1'=>"To go back to the main menu, press 1",
	 'transfer_credit2'=>"To exit, Please hang-up. Thank you.",
	  'transfer_credit3'=>", your transfer request has been accepted to",
	  'transfer_credit4'=>"The sum of will be debited from your Account.",
	  'transfer_credit5'=>"Your new account balance is",
	   'transfer_credit6'=>"Please allow about 1 to 2 business days for your transfer to take full effect.",
	   'transfer_credit7'=>"You have entered an invalid Transfer Token code.",
	   'transfer_credit8'=>'Please Enter your 5 digit "SECRET TRANSFER TOKEN CODE" followed by the Pound key.',
 
	   'transfer_credit9'=>"Sorry, I didn't get your TRANSFER TOKEN CODE",
		'dontGetResponse' => "Sorry, I didn't get your response",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		];
		
		$Array['de-DE'] = [
		'handle1' =>'If you have your Telephone Bank login details or ATM Debit Card Number Press 1',
		'handle2' =>'To Speak to Customer Care support press 2.',
		'dontGetResponse' => "Sorry, I didn't get",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		];
		
		$Array['ja-JP'] = [
		'handle1' =>'If you have your Telephone Bank login details or ATM Debit Card Number Press 1',
		'handle2' =>'To Speak to Customer Care support press 2.',
		'dontGetResponse' => "Sorry, I didn't get",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		];
		
		$Array['pt'] = [
		'handle1' =>'If you have your Telephone Bank login details or ATM Debit Card Number Press 1',
		'handle2' =>'To Speak to Customer Care support press 2.',
		'dontGetResponse' => "Sorry, I didn't get",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		];
		
		$Array['ar'] = [
		'handle1' =>'If you have your Telephone Bank login details or ATM Debit Card Number Press 1',
		'handle2' =>'To Speak to Customer Care support press 2.',
		'dontGetResponse' => "Sorry, I didn't get",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		];
		
		return $Array[$language][$index];
		
	}
   
}
/*
'Welcome_user8'=>'forward_static_call(function) credit transfer, press 2',*/