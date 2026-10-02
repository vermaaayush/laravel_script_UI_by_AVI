<?php

namespace App\Http\Controllers\ivr;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Http\Request;


class IvrLanguageController extends Controller
{
	
		
	public function index($language,$index){
		
		
		$Array['en'] = [
        'overdraft' =>'Your account is currently in overdraft',
		'handle1' =>'If you have your Telephone Banking login details or ATM Debit Card Number Please Press 1',
		'handle2' =>'To Speak to Customer Care support  Please press 2.',
		'handle3' =>'Please enter your CUSTOMER I D followed by the Pound key',
		'handle4' =>'Your call is being transfered. Please wait while we connect you.',
		'handle5' =>'Hello, Thank you for calling the Customer Care service of',
		'handle6' =>'Please kindly enter The extention number of the department you are trying to reach',
		'handle7' =>"if you doesn't have the extension number, Please stay on the line to be connected to the next available operator",
		'handle8' =>'Please note that this call may be monitored for quality and training purposes',
		'handle9' =>'A Customer Agent will be with you shortly. please hold',
		'handle10' =>'Sorry, I didnt get your CUSTOMER I D',
		'handle11' =>'A Customer representative will be with you shortly. please hold',
		'handle12' => 'Your Input is invalid',
		'handle_map1'=>"if you doesn't have the extension number,  please stay on the line to be connected to the next available operator",
		 'no_benefi' =>"No Beneficiary Account There.",
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
		'pin_login5'=>'Please press 4 to listen to your last 5 transactions',
		'pin_login6'=>'press 5 to check account status',
		'pin_login7'=>'For checking card status, press 6', //need to add changings
		'pin_login8'=>'To listen your messages, press 3',
        'pin_login9'=>'Press 7 to check linked beneficiary account',
		'pin_login10'=>'Please re-enter your PERSONAL SECRET PIN, followed by the Pound key',
		'pin_login11'=>'The SECRET PIN you entered is invalid',
		'pin_login12'=>'You have ',
		'pin_login13'=>'messages in your inbox.',
		
		'Welcome_user2'=>"Sorry, I didn't get your ACCOUNT NUMBER.",
		'Welcome_user3'=>'Please enter your ACCOUNT NUMBER followed by the Pound key.',
		
		'Welcome_user4'=>'To make a local transfer, press 1',
		'Welcome_user5'=>'To make a transfer to another bank, press 2',
		'Welcome_user51'=>'To make a transfer to your own account, press 3', 
		'Welcome_user6'=>'To go back to the MAIN MENU, press the star key',
		
		'Welcome_user7'=>'for credit limit, press 1',

		'Welcome_user8'=>'for credit transfer, press 2',
		'Welcome_user9'=>'To link a credit card account, press 3',
		'Welcome_user10'=>'Go to main menu press star key ',//need to add new
		
		'Welcome_user11'=>'To delete all message, press 2',
		'Welcome_user12'=>'your input is invalid, please enter a valid input',
		'Welcome_user13'=>'To pay Bills online and other special Account feature, press 3',

		'Welcome_user14'=>'To listen to your message number',
		'Welcome_user15'=>'Your status is Pending',
		'Welcome_user16'=>'Your status is Approved',
		'Welcome_user17'=>'Your status is Suspended',
		'Welcome_user18'=>'Your status is Blocked', //need to add new
		'accout_balance_login1'=>'Last Five Transactions  Details for this account',
		'accout_balance_login2'=>'To listen to your Transactions  again press star, To go back to your main Account Menu press 1',
		'accout_balance_login3'=>'Type of Account:',
		'accout_balance_login4'=>'Your Account Balance is',
		'accout_status_suspend1'=>'Status, Your Account is Suspended',
		'accout_status_suspend2'=>'Status, ',
		'accout_status_suspend3'=>'This user profile is currently disabled from accessing this facility, Please visit your nearest branch to  enable this facility in your profile, and allow  you effect transfer to other banks',
		                             
		
		'accout_balance_login5'=>' To listen to your Account balance again press star, To go back to your main Account Menu press 1',
		'accout_balance_login6'=>'The Account Number you entered is invalid',
		'accout_balance_login7'=>'Please re-enter your Account Number',

		'accout_balance_login8'=>'You have entered an invalid Input',
		'transfer_type1'=>'Please note for security reasons, you can only transfer to a saved linked account. and Must be same currency', //need to change
		'transfer_type2'=>'You currently have no saved linked "beneficiary Accounts". Please visit your nearest branch to link a beneficiary account, in other to be able to effect transfer to other banks.',  
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
 	  'transfer_acc_amount3'=>'The Token Number you entered is invalid.', //need to change
 	  'transfer_acc_amount4'=>'Please re-enter the Routing Number, followed by the Pound key',
 	  
 	  'transfer_token1'=>'Amount Accepted',
 	  'transfer_token2'=>'You have requested to transfer the sum of',
 	
 	 'transfer_token4'=>'Amount not accepted due to insufficient Balance', //need to change new insufficiant speeling is wrong
 	 'transfer_token5'=>'Please Enter a Valid AMOUNT followed by the Pound key',
	 'transfer_token6'=>'Invalid account Number please re enter the account number', //need to add new

 	 'transfer_link_acc1'=>'Your registered linked beneficiary accounts are',  
 	 'transfer_link_accb'=>'Your registered Beneficiary accounts are ', //newadded
 	 'transfer_typeb'=>'Please note for security reasons, you can only transfer to a saved Beneficiary account ', //newadded
 	 'transfer_link_accb1'=>'To Choose this Beneficiary account number ',//newadded
	 
	 
 	  'transfer_link_acc2'=>'To Choose Transfer From Account number', 
	  'transfer_link_acc3'=>' Press ', 
	  'transfer_link_acc4'=>'Please enter your Beneficiary Account number followed by the Pound key. ', 
	  'transfer_link_acc5'=>'To Choose Transfer To Account number', 

      'transfer_link_acc6'=>'Beneficiary Account number is invalid', 
      'transfer_link_acc7'=>'Beneficiary User is suspended', 
      'transfer_link_acc8'=>"Beneficiary User isn\'t approved yet.",
      'transfer_link_acc9'=>'Beneficiary Account Currency does not match Debit Account Currency', 
      'transfer_link_acc10'=>'Please enter your ', 
      'transfer_link_acc11'=>'You entered is invalid', 
	  'transfer_link_acc12'=>'Please Note that a transaction charge of 0.002% is applicable to this transfer', //need to add new
	  'transfer_link_acc13'=>'We will be deducting this charges from the selected account number, please press 1 to countinue ', // newadded
	 
	 
 	  'transfer_acc_sort1'=>'Enter the Routing Number, followed by the Pound key',
 	  'transfer_acc_sort2'=>"Sorry, I didn't get the Routing Number.",
	 
	 
 	  'transfer_acc_sort3'=>"This Account Number is not linked for transfer.",
 	  'transfer_acc_sort4'=>"Please re-enter a registered linked Account Number, followed by the Pound key",		
 	  'transfer_credit1'=>"To go back to the main menu, press 1",
	  'transfer_credit2'=>"To exit, Please hang-up. Thank you.",
	 
	  'transfer_credit3'=>", your transfer request has been accepted",
	  'transfer_credit4'=>"Amount has been debited from your Account.",
	  'transfer_credit5'=>"Your new account balance is",
	  'transfer_credit6'=>"Please allow about 1 to 2 business days for transfered funds to reach beneficiary account.",
	   
	   
	   
	   'transfer_credit7'=>"You have entered an invalid Transfer Token code.",
	   'transfer_credit8'=>'Please Enter your 5 digit "SECRET TRANSFER TOKEN CODE" followed by the Pound key.',
 
	   'transfer_credit9'=>"Sorry, I didn't get your TRANSFER TOKEN CODE",
		'dontGetResponse' => "Sorry, I didn't get your response",
		'ExceedLimit' => "You have exceeded your time-out limit. Good Bye.",
		'invalidInput' => 'Your input is invalid, please try again',

		'handlex3' => 'For new accounts, products and services information, please press 3',
		'handlex4' => 'For loan and cargo deposit information, please press 4',

		'main3_intro' => 'Welcome to our products and services menu.',
		'main3_opt1' => 'For product information, press 1',
		'main3_opt2' => 'To speak to customer service, press 2',
		'main3_opt0' => 'To return to the main menu, press 0',
		'main3_sub_intro' => 'Please select a product to learn more about.',
		'main3_sub_opt1' => 'For savings account information, press 1',
		'main3_sub_opt2' => 'For loan information, press 2',
		'main3_sub_opt3' => 'For investment information, press 3',
		'main3_sub_opt0' => 'To return to the previous menu, press 0',
		'main3_savings' => 'Our savings accounts offer competitive interest rates with easy access to your funds.',
		'main3_loans' => 'We offer a range of loan products to suit your needs, including personal and business loans.',
		'main3_investments' => 'Our investment products are designed to help you grow your savings over time.',

		'main4_intro' => 'Welcome to our loan and cargo deposit menu.',
		'main4_opt1' => 'For loan and repayment information, press 1',
		'main4_opt2' => 'For cargo deposit information, press 2',
		'main4_opt0' => 'To return to the main menu, press 0',
		'main4_loans' => 'Please select an option for loan information.',
		'main4_loans_opt1' => 'For your loan balance, press 1',
		'main4_loans_opt2' => 'For repayment information, press 2',
		'main4_loans_opt0' => 'To return to the previous menu, press 0',
		'main4_cargo' => 'For cargo deposit enquiries, please visit your nearest branch or contact customer support.',
		'main4_balance' => 'Your current loan balance will be read out shortly.',
		'main4_repayment' => 'Your next repayment details will be read out shortly.',

		];
		
		$Array['es-ES'] = [
    'overdraft' => 'Su cuenta está actualmente en sobregiro',
    'handle1' => 'Si tiene los detalles de inicio de sesión de su Banca Telefónica o el número de tarjeta de débito de cajero automático, presione 1',
    'handle2' => 'Para hablar con el soporte de Atención al Cliente, presione 2.',
    'handle3' => 'Por favor, ingrese su IDENTIFICACIÓN DE CLIENTE seguido de la tecla de la libra',
    'handle4' => 'Su llamada está siendo transferida. Espere mientras lo conectamos.',
    'handle5' => 'Hola, gracias por llamar al servicio de Atención al Cliente de',
    'handle6' => 'Por favor, ingrese el número de extensión del departamento al que intenta comunicarse',
    'handle7' => 'Si no tiene el número de extensión, permanezca en la línea para ser conectado con el siguiente operador disponible',
    'handle8' => 'Tenga en cuenta que esta llamada puede ser monitoreada para fines de calidad y capacitación',
    'handle9' => 'Un agente de atención al cliente estará con usted en breve. Por favor, espere',
    'handle10' => 'Lo siento, no entendí su IDENTIFICACIÓN DE CLIENTE',
    'handle11' => 'Un representante de atención al cliente estará con usted en breve. Por favor, espere',
    'handle12' => 'Su entrada no es válida',
    'handle_map1' => 'Si no tiene el número de extensión, permanezca en la línea para ser conectado con el siguiente operador disponible',
    'no_benefi' => 'No hay cuenta beneficiaria.',
    'handle_map' => 'Lo sentimos, no podemos encontrar el número de extensión que ingresó, intente nuevamente con un número de extensión válido',
    'handle_map2' => 'Por favor, ingrese nuevamente el número de extensión',
    
    'customer_id_login1' => 'Ingrese su IDENTIFICACIÓN DE USUARIO seguida de la tecla de la libra.',
    'customer_id_login2' => 'Lo siento, no entendí su IDENTIFICACIÓN DE USUARIO',
    'customer_id_login3' => 'La IDENTIFICACIÓN DE CLIENTE no es válida',
    'customer_id_login4' => 'Por favor, vuelva a ingresar su IDENTIFICACIÓN DE CLIENTE seguida de la tecla de la libra',

    'user_id_login1' => 'Por favor, ingrese su PIN SECRETO personal seguido de la tecla de la libra',
    'user_id_login2' => 'Lo siento, no entendí su PIN SECRETO.',
    'user_id_login4' => 'La IDENTIFICACIÓN DE USUARIO que ingresó no es válida.',
    'user_id_login5' => 'Por favor, vuelva a ingresar su IDENTIFICACIÓN DE USUARIO, seguida de la tecla de la libra',

    'pin_login1' => 'Lo siento, su cuenta está bloqueada. ¡Por favor, contacte al soporte al cliente! Gracias',
    'pin_login2' => 'Bienvenido de nuevo',
    'pin_login3' => 'Para verificar su saldo de cuenta, presione 1',
    'pin_login4' => 'Para solicitudes de transferencia en línea, presione 2',
    'pin_login5' => 'Por favor, presione 4 para escuchar sus últimas 5 transacciones',
    'pin_login6' => 'Presione 5 para verificar el estado de la cuenta',
    'pin_login7' => 'Para verificar el estado de la tarjeta, presione 6',
    'pin_login8' => 'Para escuchar sus mensajes, presione 3',
    'pin_login9' => 'Presione 7 para verificar la cuenta beneficiaria vinculada',
    'pin_login10' => 'Por favor, vuelva a ingresar su PIN SECRETO PERSONAL seguido de la tecla de la libra',
    'pin_login11' => 'El PIN SECRETO que ingresó no es válido',
    'pin_login12' => 'Tiene',
    'pin_login13' => 'mensajes en su bandeja de entrada.',

    'Welcome_user2' => 'Lo siento, no entendí su NÚMERO DE CUENTA.',
    'Welcome_user3' => 'Por favor, ingrese su NÚMERO DE CUENTA seguido de la tecla de la libra.',
    
    'Welcome_user4' => 'Para realizar una transferencia local, presione 1',
    'Welcome_user5' => 'Para realizar una transferencia a otro banco, presione 2',
    'Welcome_user51' => 'Para transferir a su propia cuenta, presione 3',
    'Welcome_user6' => 'Para volver al MENÚ PRINCIPAL, presione la tecla de estrella',

    'Welcome_user7' => 'Para límite de crédito, presione 1',
    'Welcome_user8' => 'Para transferencia de crédito, presione 2',
    'Welcome_user9' => 'Para vincular una cuenta de tarjeta de crédito, presione 3',
    'Welcome_user10' => 'Para volver al menú principal, presione la tecla de estrella',
    
    'Welcome_user11' => 'Para eliminar todos los mensajes, presione 2',
    'Welcome_user12' => 'Su entrada no es válida, por favor ingrese una entrada válida',
    'Welcome_user13' => 'Para pagar facturas en línea y otras funciones especiales de la cuenta, presione 3',

    'Welcome_user14' => 'Para escuchar su mensaje número',
    'Welcome_user15' => 'Su estado es Pendiente',
    'Welcome_user16' => 'Su estado es Aprobado',
    'Welcome_user17' => 'Su estado es Suspendido',
    'Welcome_user18' => 'Su estado es Bloqueado',

    'accout_balance_login1' => 'Últimos cinco detalles de transacciones de esta cuenta',
    'accout_balance_login2' => 'Para escuchar nuevamente sus transacciones, presione estrella. Para volver al menú principal de su cuenta, presione 1',
    'accout_balance_login3' => 'Tipo de cuenta:',
    'accout_balance_login4' => 'Su saldo de cuenta es',
    'accout_status_suspend1' => 'Estado, su cuenta está suspendida',
    'accout_status_suspend2' => 'Estado,',
    'accout_status_suspend3' => 'Este perfil de usuario está actualmente deshabilitado para acceder a esta facilidad. Por favor, visite su sucursal más cercana para habilitar esta facilidad en su perfil y permitirle transferir a otros bancos',

    'accout_balance_login5' => 'Para escuchar nuevamente su saldo de cuenta, presione estrella. Para volver al menú principal de su cuenta, presione 1',
    'accout_balance_login6' => 'El número de cuenta que ingresó no es válido',
    'accout_balance_login7' => 'Por favor, vuelva a ingresar su número de cuenta',

    'accout_balance_login8' => 'Ha ingresado una entrada no válida',
    'transfer_type1' => 'Tenga en cuenta que, por razones de seguridad, solo puede transferir a una cuenta beneficiaria guardada y debe ser de la misma moneda',
    'transfer_type2' => 'Actualmente no tiene cuentas beneficiarias vinculadas. Por favor, visite su sucursal más cercana para vincular una cuenta beneficiaria y poder realizar transferencias a otros bancos.',
    'transfer_type3' => 'Para seleccionar una cuenta para realizar su transferencia, presione la tecla estrella',

    'credit_process1' => 'Su saldo de cuenta de crédito es',
    'credit_process2' => 'Para continuar con el proceso, elija desde el menú principal.',
    'credit_process3' => 'No tiene ninguna cuenta de crédito vinculada.',
    'credit_process4' => 'Para vincular su cuenta de crédito, elija desde el menú principal.',
    'credit_process5' => 'Para realizar una transferencia, la tarjeta de crédito debe estar vinculada. Para escuchar las tarjetas vinculadas disponibles, presione 1',
    'credit_process6' => 'Para recibir la solicitud por correo, presione 1. Para recibir la solicitud por correo electrónico, presione 2',

    'credit_process01' => 'Tiene las siguientes tarjetas vinculadas,',
    'credit_process02' => 'tiene un',
    'credit_process03' => 'Por favor, ingrese los últimos 6 dígitos de la tarjeta de crédito',
    'credit_process04' => 'Esta cuenta de tarjeta pertenece a',
    'credit_process05' => 'Por favor, ingrese el monto',
    'credit_process06' => 'Usted envió',
    'credit_process07' => 'La información ingresada no es válida, por favor, vuelva a ingresar los 6 dígitos',
    'credit_process07' => 'Por favor, ingrese el token',
    'credit_process08' => 'Su transferencia ha sido iniciada. Espere de 12 a 24 horas para su finalización',

    'credit_process001' => 'El monto es mayor que su saldo restante, por favor, vuelva a ingresar un nuevo monto',
    'credit_process002' => 'El formulario de solicitud ha sido enviado a la dirección registrada. Gracias',
    'credit_process003' => 'El correo electrónico no funciona',
    'credit_process004' => 'El formulario de solicitud ha sido enviado a la dirección de correo electrónico registrada. Gracias',

    'transfer_acc_amount1' => 'Los detalles de esta cuenta registrada pertenecen a',
    'transfer_acc_amount2' => 'Por favor, introduzca la cantidad a transferir seguida de la tecla de almohadilla (#).',
    'transfer_acc_amount3' => 'El número de token que ingresó es inválido.',
    'transfer_acc_amount4' => 'Por favor, vuelva a ingresar el número de ruta seguido de la tecla de almohadilla (#).',
    
    'transfer_token1' => 'Cantidad aceptada',
    'transfer_token2' => 'Ha solicitado transferir la suma de',
    
    'transfer_token4' => 'Cantidad no aceptada debido a saldo insuficiente.',
    'transfer_token5' => 'Por favor, ingrese una CANTIDAD válida seguida de la tecla de almohadilla (#).',
    'transfer_token6' => 'Número de cuenta inválido, por favor vuelva a ingresar el número de cuenta.',

    'transfer_link_acc1' => 'Sus cuentas beneficiarias registradas vinculadas son',
    'transfer_link_accb' => 'Sus cuentas beneficiarias registradas son', //agregado
    'transfer_typeb' => 'Tenga en cuenta que, por razones de seguridad, solo puede transferir a una cuenta beneficiaria guardada.', //agregado
    'transfer_link_accb1' => 'Para elegir este número de cuenta beneficiaria', //agregado
    
    'transfer_link_acc2' => 'Para elegir Transferir desde el número de cuenta',
    'transfer_link_acc3' => 'Presione',
    'transfer_link_acc4' => 'Por favor, ingrese el número de cuenta beneficiaria seguido de la tecla de almohadilla (#).',
    'transfer_link_acc5' => 'Para elegir Transferir al número de cuenta',

    'transfer_link_acc6' => 'El número de cuenta beneficiaria es inválido',
    'transfer_link_acc7' => 'El usuario beneficiario está suspendido',
    'transfer_link_acc8' => 'El usuario beneficiario no está aprobado aún.',
    'transfer_link_acc9' => 'La moneda de la cuenta beneficiaria no coincide con la moneda de la cuenta de débito.',
    'transfer_link_acc10' => 'Por favor, introduzca su',
    'transfer_link_acc11' => 'Lo que ingresó es inválido.',
    'transfer_link_acc12' => 'Tenga en cuenta que se aplicará un cargo de transacción del 0.002% a esta transferencia.', //agregado
    'transfer_link_acc13' => 'Deduciremos estos cargos de la cuenta seleccionada, por favor presione 1 para continuar.', //agregado

    'transfer_acc_sort1' => 'Ingrese el número de ruta seguido de la tecla de almohadilla (#).',
    'transfer_acc_sort2' => 'Lo siento, no obtuve el número de ruta.',

    'transfer_acc_sort3' => 'Este número de cuenta no está vinculado para la transferencia.',
    'transfer_acc_sort4' => 'Por favor, vuelva a ingresar un número de cuenta registrado vinculado, seguido de la tecla de almohadilla (#).',
    
    'transfer_credit1' => 'Para volver al menú principal, presione 1',
    'transfer_credit2' => 'Para salir, por favor cuelgue. Gracias.',

    'transfer_credit3' => ', su solicitud de transferencia ha sido aceptada',
    'transfer_credit4' => 'Se ha debitado la cantidad de su cuenta.',
    'transfer_credit5' => 'Su nuevo saldo de cuenta es',
    'transfer_credit6' => 'Por favor, permita entre 1 y 2 días hábiles para que los fondos transferidos lleguen a la cuenta del beneficiario.',

    'transfer_credit7' => 'Ha ingresado un código de token de transferencia inválido.',
    'transfer_credit8' => 'Por favor, ingrese su "CÓDIGO SECRETO DE TOKEN DE TRANSFERENCIA" de 5 dígitos seguido de la tecla de almohadilla (#).',

    'transfer_credit9' => 'Lo siento, no obtuve su CÓDIGO DE TOKEN DE TRANSFERENCIA.',
    'dontGetResponse' => 'Lo siento, no obtuve su respuesta.',
    'ExceedLimit' => 'Ha excedido su límite de tiempo de espera. Adiós.',
    'invalidInput' => 'Su entrada no es válida, por favor intente de nuevo',

    'handlex3' => 'Para información sobre nuevas cuentas, productos y servicios, presione 3',
    'handlex4' => 'Para información sobre préstamos y depósitos de carga, presione 4',

    'main3_intro' => 'Bienvenido a nuestro menú de productos y servicios.',
    'main3_opt1' => 'Para información de productos, presione 1',
    'main3_opt2' => 'Para hablar con servicio al cliente, presione 2',
    'main3_opt0' => 'Para volver al menú principal, presione 0',
    'main3_sub_intro' => 'Seleccione un producto para obtener más información.',
    'main3_sub_opt1' => 'Para información de cuentas de ahorro, presione 1',
    'main3_sub_opt2' => 'Para información de préstamos, presione 2',
    'main3_sub_opt3' => 'Para información de inversiones, presione 3',
    'main3_sub_opt0' => 'Para volver al menú anterior, presione 0',
    'main3_savings' => 'Nuestras cuentas de ahorro ofrecen tasas de interés competitivas con fácil acceso a sus fondos.',
    'main3_loans' => 'Ofrecemos una variedad de préstamos para adaptarse a sus necesidades, incluidos préstamos personales y comerciales.',
    'main3_investments' => 'Nuestros productos de inversión están diseñados para ayudarlo a hacer crecer sus ahorros con el tiempo.',

    'main4_intro' => 'Bienvenido a nuestro menú de préstamos y depósitos de carga.',
    'main4_opt1' => 'Para información de préstamos y pagos, presione 1',
    'main4_opt2' => 'Para información de depósitos de carga, presione 2',
    'main4_opt0' => 'Para volver al menú principal, presione 0',
    'main4_loans' => 'Seleccione una opción para información de préstamos.',
    'main4_loans_opt1' => 'Para su saldo de préstamo, presione 1',
    'main4_loans_opt2' => 'Para información de pagos, presione 2',
    'main4_loans_opt0' => 'Para volver al menú anterior, presione 0',
    'main4_cargo' => 'Para consultas sobre depósitos de carga, visite su sucursal más cercana o contacte a soporte al cliente.',
    'main4_balance' => 'Su saldo de préstamo actual se leerá en breve.',
    'main4_repayment' => 'Los detalles de su próximo pago se leerán en breve.',

      ];
		
		$Array['fr-FR'] = [
		'handle1' =>'Si vous avez vos coordonnées bancaires téléphoniques ou votre numéro de carte de débit ATM, appuyez sur 1',
		'handle2' =>'Pour parler au support client, appuyez sur 2.',
		'handle3' =>'Veuillez saisir votre IDENTITÉ DU CLIENT suivi de la touche Dièse',
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
		
		'customer_id_login1'=>'Entrez votre USER I D suivi de la touche Dièse.',
		'customer_id_login2'=>"Désolé, je n'ai pas obtenu votre USER I D",
		'customer_id_login3'=>'Le CLIENT I D est invalide',
		'customer_id_login4'=>'Veuillez saisir à nouveau votre CLIENT I D suivi de la touche Dièse',
		
		'user_id_login1'=>'Veuillez saisir votre PIN SECRET personnel, suivi de la touche Dièse',
		'user_id_login2'=>"Désolée, je n'ai pas reçu votre NIP SECRET.",
		'user_id_login4'=>"L'UTILISATEUR I D que vous entrez n'est pas valide.",	
		'user_id_login5'=>'Veuillez saisir à nouveau votre USER I D, suivi de la touche Dièse',
		
		'pin_login1'=>'Désolé, votre compte est bloqué Veuillez contacter le service client! Merci',
		'pin_login2'=>'Nous saluons le retour',
		'pin_login3'=>'Pour vérifier le solde de votre compte, appuyez sur 1',
		'pin_login4'=>'Pour les demandes de transfert en ligne, appuyez sur 2',
		'pin_login5'=>'appuyez sur 4 pour écouter vos 5 dernières transactions',
		'pin_login6'=>"appuyez sur 5 pour vérifier l'état du compte",
		
		'pin_login7'=>"Pour vérifier l'état de la carte, appuyez sur 6", 
		'pin_login8'=>'Pour écouter vos messages, appuyez sur 3',
		'pin_login10'=>'Veuillez saisir à nouveau votre NIP PERSONNEL SECRET, suivi de la touche Dièse',
		'pin_login11'=>"Le code PIN SECRET que vous avez entré n'est pas valide",
		'pin_login12'=>'Vous avez ',
		'pin_login13'=>'messages dans votre boîte de réception.',
		
		'Welcome_user2'=>"Désolé, je n'ai pas obtenu votre NUMÉRO DE COMPTE.",
		'Welcome_user3'=>'Veuillez entrer votre NUMÉRO DE COMPTE suivi de la touche dièse.',
		
		'Welcome_user4'=>'Pour effectuer un transfert local, appuyez sur 1',
		'Welcome_user5'=>'Pour effectuer un virement vers une autre banque, appuyez sur 2',
		'Welcome_user51'=>'Pour effectuer un virement vers votre propre compte, appuyez sur 3', 
		'Welcome_user6'=>'Pour revenir au MENU PRINCIPAL, appuyez sur la touche étoile',
		
		'Welcome_user7'=>'pour la limite de crédit, appuyez sur 1',

		'Welcome_user8'=>'pour le virement, appuyez sur 2',
		'Welcome_user9'=>'Pour lier un compte de carte de crédit, appuyez sur 3',
		'Welcome_user10'=>'Aller au menu principal appuyez sur la touche étoile',
		'Welcome_user11'=>'Pour supprimer tous les messages, appuyez sur 2',
		'Welcome_user12'=>"votre entrée n'est pas valide, veuillez entrer une entrée valide",
		'Welcome_user13'=>"Pour payer des factures en ligne et d'autres fonctions spéciales de compte, appuyez sur 3",

		'Welcome_user14'=>'vous écoutez le numéro du message',
		'Welcome_user15'=>'Votre statut est en attente',
		'Welcome_user16'=>'Votre statut est approuvé',
		'Welcome_user17'=>'Votre statut est suspendu',
		'Welcome_user18'=>'Votre statut est bloqué', 
		'accout_balance_login1'=>'Détails des cinq dernières transactions pour votre compte',
		'accout_balance_login2'=>'Pour écouter à nouveau vos transactions, appuyez sur étoile Pour revenir au menu principal de votre compte, appuyez sur 1',
		'accout_balance_login3'=>'Type de compte:',
		'accout_balance_login4'=>'Le solde de votre compte est',
		
		'accout_balance_login5'=>'Pour réécouter le solde de votre compte, appuyez sur étoile Pour revenir au menu principal de votre compte, appuyez sur 1',
		'accout_balance_login6'=>"Le numéro de compte que vous avez entré n'est pas valide",
		'accout_balance_login7'=>'Veuillez saisir à nouveau votre numéro de compte',

		'accout_balance_login8'=>'Vous avez entré une entrée non valide',
		'transfer_type1'=>'Veuillez noter que pour des raisons de sécurité, vous ne pouvez transférer que vers un compte associé enregistré. correspondant à la même devise', 

		'transfer_type2'=>"Vous n'avez actuellement aucun 'Comptes locaux' associés enregistrés. Veuillez visiter votre succursale la plus proche pour lier un compte, pour effectuer un virement local.",  
		'transfer_type3'=>'Pour sélectionner un compte pour effectuer votre transfert, appuyez sur la touche étoile',

		'credit_process1'=>'Le solde de votre compte de crédit est',
		'credit_process2'=>'Pour poursuivre le processus, veuillez choisir dans le menu principal.',
		'credit_process3'=>"Vous n'avez aucun compte de crédit lié.",
		'credit_process4'=>'Pour lier votre compte de crédit Veuillez choisir dans le menu principal.',
		'credit_process5'=>'Pour effectuer un virement, la carte de crédit doit être liée, pour écouter les cartes liées disponibles, appuyez sur 1',
		'credit_process6'=>'Pour recevoir une demande par e-mail, appuyez sur 1, Pour recevoir une demande par e-mail, appuyez sur 2',

		'credit_process01'=>'Vous avez les cartes suivantes liées,',
		'credit_process02'=>'tu as un',
		'credit_process03'=>'Veuillez saisir les 6 derniers chiffres de la carte de crédit',
		'credit_process04'=>'Ce compte de carte appartient à',
		'credit_process05'=>'Veuillez saisir le montant',
		'credit_process06'=>'Vous avez poussé',
	    'credit_process07'=>'Ces informations saisies ne sont pas valides, veuillez saisir à nouveau les 6 chiffres',
		'credit_process07'=>'Veuillez saisir le jeton',
		'credit_process08'=>'Votre transfert a été initié. Donnez 12 à 24 heures pour terminer',

		'credit_process001'=>'Le montant est supérieur au montant restant, veuillez saisir à nouveau le nouveau montant',
		'credit_process002'=>"Le formulaire de demande a été envoyé à l'adresse enregistrée Merci",
 	  'credit_process003'=>"L'e-mail ne fonctionne pas",
 	  'credit_process004'=>"Le formulaire de demande a été envoyé à l'adresse e-mail dans le fichier Merci",

 	  'transfer_acc_amount1'=>'Les détails de ce compte enregistré appartiennent à',
 	  'transfer_acc_amount2'=>'Veuillez entrer le montant à transférer suivi de la touche Dièse.',
 	  
 	  'transfer_acc_amount3'=>"Le numéro de jeton que vous avez entré n'est pas valide.", 
 	  'transfer_acc_amount4'=>'Veuillez saisir à nouveau le numéro de routage, suivi de la touche dièse',
 	  
 	  'transfer_token1'=>'Montant accepté',
 	  'transfer_token2'=>'Vous avez demandé le transfert de la somme de',
 	 'transfer_token4'=>"Montant non accepté en raison d'un solde insuffisant",
 	 'transfer_token5'=>'Veuillez saisir un montant valide suivi de la touche dièse',
 	'transfer_token6'=>'Numéro de compte non valide, veuillez saisir à nouveau le numéro de compte',
     'transfer_link_acc1'=>'Vos comptes liés enregistrés sont',
     'transfer_link_accb'=>'Vos comptes de Bénéficiaires enregistrés sont ', //newadded
 	 'transfer_typeb'=>'Veuillez noter que pour des raisons de sécurité, vous ne pouvez transférer que vers un compte de bénéficiaire enregistré ', //newadded
 	 'transfer_link_accb1'=>'Pour Choisir ce Numéro de Bénéficiaire est ',//newadded
	
	 
 	 'transfer_link_acc2'=>'Pour choisir le transfert depuis le numéro de compte', 
	 'transfer_link_acc3'=>'presse', 
	 'transfer_link_acc4'=>'Veuillez saisir votre numéro de compte de bénéficiaire suivi de la touche Dièse.', 
	 'transfer_link_acc5'=>'Pour choisir le transfert vers le numéro de compte', 
	 'transfer_link_acc6'=>"Le numéro de compte du bénéficiaire n'est pas valide", 
	 'transfer_link_acc7'=>"L'utilisateur bénéficiaire est suspendu", 
	 'transfer_link_acc8'=>"L’utilisateur bénéficiaire n’est pas encore approuvé.", 
	 'transfer_link_acc9'=>'La devise du compte du bénéficiaire ne correspond pas à la devise du compte de débit', 
	 'transfer_link_acc10'=>"S'il vous plait entrez votre", 
	'transfer_link_acc11'=>'Vous avez entré invalide', 
		'transfer_link_acc12'=>'Veuillez noter que le débit pour les frais est de 0.002% de chaque transfert', 
		
		'transfer_link_acc13'=>'Nous choisissons votre numéro de compte pour les frais de déduction, veuillez appuyer sur 1 pour continuer ', // newadded
 	 'transfer_acc_sort1'=>"Entrez le numéro d'acheminement, suivi de la touche dièse",
 	 'transfer_acc_sort2'=>"Pardon, je n'ai pas obtenu le numéro de routage.",
 	  'transfer_acc_sort3'=>"Ce numéro de compte n'est pas lié pour le transfert.",
 	  'transfer_acc_sort4'=>"Veuillez saisir à nouveau un numéro de compte lié enregistré, suivi de la touche dièse",		
 	  'transfer_credit1'=>"Pour revenir au menu principal, appuyez sur 1",
	 'transfer_credit2'=>"Pour quitter, veuillez raccrocher. Je vous remercie.",
	  'transfer_credit3'=>", votre demande de transfert a été acceptée à",
	  'transfer_credit4'=>"La somme de sera débitée de votre compte.",
	  'transfer_credit5'=>"Le solde de votre nouveau compte est",
	   'transfer_credit6'=>"Veuillez prévoir environ 1 à 2 jours ouvrables pour que votre transfert prenne pleinement effet.",
	   'transfer_credit7'=>"Vous avez entré un code de jeton de transfert non valide.",
	   'transfer_credit8'=>'Veuillez entrer votre "CODE DE JETON DE TRANSFERT SECRET" à 5 chiffres suivi de la touche dièse.',
 
	   'transfer_credit9'=>"Désolé, je n'ai pas reçu votre CODE DE JETON DE TRANSFERT",
		'dontGetResponse' => "Désolé, je n'ai pas reçu votre réponse",
		'ExceedLimit' => "Vous avez dépassé votre délai d'expiration. Au revoir.",
		];
		
		$Array['de-DE'] = [
    'overdraft' =>'Ihr Konto ist derzeit überzogen',
    'handle1' =>'Wenn Sie Ihre Telefonbanking-Anmeldedaten oder die Nummer Ihrer ATM-Debitkarte haben, drücken Sie bitte 1',
    'handle2' =>'Um mit dem Kundenservice zu sprechen, drücken Sie bitte 2.',
    'handle3' =>'Bitte geben Sie Ihre KUNDEN-ID ein, gefolgt von der Raute-Taste',
    'handle4' =>'Ihr Anruf wird weitergeleitet. Bitte warten Sie, während wir Sie verbinden.',
    'handle5' =>'Hallo, vielen Dank, dass Sie den Kundenservice von',
    'handle6' =>'Bitte geben Sie die Durchwahl der Abteilung ein, die Sie erreichen möchten',
    'handle7' =>'Wenn Sie die Durchwahl nicht haben, bleiben Sie bitte in der Leitung, um mit dem nächsten verfügbaren Mitarbeiter verbunden zu werden',
    'handle8' =>'Bitte beachten Sie, dass dieses Gespräch zu Qualitäts- und Schulungszwecken überwacht werden kann',
    'handle9' =>'Ein Kundenberater wird gleich bei Ihnen sein. Bitte warten',
    'handle10' =>'Entschuldigung, ich habe Ihre KUNDEN-ID nicht verstanden',
    'handle11' =>'Ein Kundenberater wird gleich bei Ihnen sein. Bitte warten',
    'handle12' => 'Ihre Eingabe ist ungültig',
    'handle_map1'=>"Wenn Sie die Durchwahl nicht haben, bleiben Sie bitte in der Leitung, um mit dem nächsten verfügbaren Mitarbeiter verbunden zu werden",
    'no_benefi' =>"Kein Begünstigtenkonto vorhanden.",
    'handle_map'=>"Entschuldigung, wir konnten die von Ihnen eingegebene Durchwahl nicht finden. Bitte versuchen Sie es erneut mit einer gültigen Durchwahl",
    'handle_map2'=>'Bitte geben Sie die Durchwahl erneut ein',
    
    'customer_id_login1'=>'Geben Sie Ihre BENUTZER-ID ein, gefolgt von der Raute-Taste.',
    'customer_id_login2'=>"Entschuldigung, ich habe Ihre BENUTZER-ID nicht verstanden",
    'customer_id_login3'=>'Die KUNDEN-ID ist ungültig',
    'customer_id_login4'=>'Bitte geben Sie Ihre KUNDEN-ID erneut ein, gefolgt von der Raute-Taste',
    
    'user_id_login1'=>'Bitte geben Sie Ihre persönliche GEHEIM-PIN ein, gefolgt von der Raute-Taste',
    'user_id_login2'=>"Entschuldigung, ich habe Ihre GEHEIM-PIN nicht verstanden.",
    'user_id_login4'=>'Die von Ihnen eingegebene BENUTZER-ID ist ungültig.',    
    'user_id_login5'=>'Bitte geben Sie Ihre BENUTZER-ID erneut ein, gefolgt von der Raute-Taste',
    
    'pin_login1'=>'Entschuldigung, Ihr Konto ist gesperrt. Bitte wenden Sie sich an den Kundendienst! Vielen Dank',
    'pin_login2'=>'Willkommen zurück',
    'pin_login3'=>'Um Ihren Kontostand zu überprüfen, drücken Sie 1',
    'pin_login4'=>'Für Online-Überweisungen drücken Sie 2',
    'pin_login5'=>'Bitte drücken Sie 4, um sich Ihre letzten 5 Transaktionen anzuhören',
    'pin_login6'=>'Drücken Sie 5, um den Kontostatus zu überprüfen',
    'pin_login7'=>'Um den Kartenstatus zu überprüfen, drücken Sie 6',
    'pin_login8'=>'Um Ihre Nachrichten anzuhören, drücken Sie 3',
    'pin_login9'=>'Drücken Sie 7, um ein verknüpftes Begünstigtenkonto zu überprüfen',
    'pin_login10'=>'Bitte geben Sie Ihre persönliche GEHEIM-PIN erneut ein, gefolgt von der Raute-Taste',
    'pin_login11'=>'Die von Ihnen eingegebene GEHEIM-PIN ist ungültig',
    'pin_login12'=>'Sie haben ',
    'pin_login13'=>'Nachrichten in Ihrem Posteingang.',
    
    'Welcome_user2'=>"Entschuldigung, ich habe Ihre KONTONUMMER nicht verstanden.",
    'Welcome_user3'=>'Bitte geben Sie Ihre KONTONUMMER ein, gefolgt von der Raute-Taste.',
    
    'Welcome_user4'=>'Um eine Inlandsüberweisung zu tätigen, drücken Sie 1',
    'Welcome_user5'=>'Um eine Überweisung an eine andere Bank zu tätigen, drücken Sie 2',
    'Welcome_user51'=>'Um eine Überweisung auf Ihr eigenes Konto zu tätigen, drücken Sie 3', 
    'Welcome_user6'=>'Um zum HAUPTMENÜ zurückzukehren, drücken Sie die Sterntaste',
    
    'Welcome_user7'=>'Für das Kreditlimit, drücken Sie 1',
    'Welcome_user8'=>'Für den Kredittransfer, drücken Sie 2',
    'Welcome_user9'=>'Um ein Kreditkartenkonto zu verknüpfen, drücken Sie 3',
    'Welcome_user10'=>'Um zum Hauptmenü zurückzukehren, drücken Sie die Sterntaste',
    
    'Welcome_user11'=>'Um alle Nachrichten zu löschen, drücken Sie 2',
    'Welcome_user12'=>'Ihre Eingabe ist ungültig, bitte geben Sie eine gültige Eingabe ein',
    'Welcome_user13'=>'Um Rechnungen online zu bezahlen und weitere spezielle Kontofunktionen zu nutzen, drücken Sie 3',
    
    'Welcome_user14'=>'Um Ihre Nachrichtennummer anzuhören, drücken Sie',
    'Welcome_user15'=>'Ihr Status ist ausstehend',
    'Welcome_user16'=>'Ihr Status ist genehmigt',
    'Welcome_user17'=>'Ihr Status ist gesperrt',
    'Welcome_user18'=>'Ihr Status ist blockiert',
    
    'accout_balance_login1'=>'Die letzten fünf Transaktionsdetails für dieses Konto',
    'accout_balance_login2'=>'Um Ihre Transaktionen erneut anzuhören, drücken Sie die Sterntaste, um zum Hauptkontomenü zurückzukehren, drücken Sie 1',
    'accout_balance_login3'=>'Kontotyp:',
    'accout_balance_login4'=>'Ihr Kontostand beträgt',
    'accout_status_suspend1'=>'Status: Ihr Konto ist gesperrt',
    'accout_status_suspend2'=>'Status:',
    'accout_status_suspend3'=>'Dieses Benutzerprofil ist derzeit für den Zugriff auf diese Funktion deaktiviert. Bitte besuchen Sie Ihre nächste Filiale, um diese Funktion zu aktivieren und Überweisungen an andere Banken durchzuführen.',
    
    'accout_balance_login5'=>'Um sich Ihren Kontostand erneut anzuhören, drücken Sie die Sterntaste, um zum Hauptkontomenü zurückzukehren, drücken Sie 1',
    'accout_balance_login6'=>'Die von Ihnen eingegebene Kontonummer ist ungültig',
    'accout_balance_login7'=>'Bitte geben Sie Ihre Kontonummer erneut ein',
    'accout_balance_login8'=>'Sie haben eine ungültige Eingabe gemacht',
    
    'transfer_type1'=>'Bitte beachten Sie, dass Sie aus Sicherheitsgründen nur auf ein verknüpftes Konto mit derselben Währung überweisen können.',
    'transfer_type2'=>'Derzeit haben Sie keine verknüpften "Begünstigtenkonten". Bitte besuchen Sie Ihre nächste Filiale, um ein Begünstigtenkonto zu verknüpfen und Überweisungen an andere Banken durchzuführen.',
    'transfer_type3'=>'Um ein Konto für Ihre Überweisung auszuwählen, drücken Sie die Sterntaste',
    
    'credit_process1'=>'Ihr Guthabenkontostand beträgt',
    'credit_process2'=>'Um fortzufahren, wählen Sie aus dem Hauptmenü.',
    'credit_process3'=>'Sie haben kein verknüpftes Kreditkonto.',
    'credit_process4'=>'Um Ihr Kreditkonto zu verknüpfen, wählen Sie aus dem Hauptmenü.',
    'credit_process5'=>'Um eine Überweisung durchzuführen, muss die Kreditkarte verknüpft sein. Um die verknüpften Karten anzuhören, drücken Sie 1',
    'credit_process6'=>'Um eine Anfrage per Post zu erhalten, drücken Sie 1, um eine Anfrage per E-Mail zu erhalten, drücken Sie 2',
    
    'credit_process01'=>'Die folgenden Karten sind verknüpft:',
    'credit_process02'=>'Sie haben eine',
    'credit_process03'=>'Bitte geben Sie die letzten 6 Ziffern der Kreditkarte ein',
    'credit_process04'=>'Dieses Kartenkonto gehört zu',
    'credit_process05'=>'Bitte geben Sie den Betrag ein',
    'credit_process06'=>'Sie haben eingegeben:',
    'credit_process07'=>'Die eingegebene Information ist ungültig, bitte geben Sie die 6 Ziffern erneut ein',
    'credit_process07'=>'Bitte geben Sie den Token ein',
    'credit_process08'=>'Ihre Überweisung wurde initiiert. Bitte geben Sie 12 bis 24 Stunden für den Abschluss der Überweisung.',
    
    'credit_process001'=>'Der Betrag ist größer als Ihr verbleibender Betrag, bitte geben Sie einen neuen Betrag ein',
    'credit_process002'=>'Das Anfrageformular wurde an die hinterlegte Adresse gesendet. Vielen Dank',
    'credit_process003'=>'Die E-Mail funktioniert nicht',
    'credit_process004'=>'Das Anfrageformular wurde an die hinterlegte E-Mail-Adresse gesendet. Vielen Dank',
    
    'transfer_acc_amount1' => 'Diese registrierten Kontodaten gehören zu',
'transfer_acc_amount2' => 'Bitte geben Sie den zu überweisenden Betrag ein, gefolgt von der Raute-Taste.',
'transfer_acc_amount3' => 'Die eingegebene Token-Nummer ist ungültig.', // geändert
'transfer_acc_amount4' => 'Bitte geben Sie die Routing-Nummer erneut ein, gefolgt von der Raute-Taste.',

'transfer_token1' => 'Betrag akzeptiert',
'transfer_token2' => 'Sie haben beantragt, die Summe von zu überweisen',

'transfer_token4' => 'Betrag nicht akzeptiert aufgrund unzureichender Deckung', // korrigierte Rechtschreibung
'transfer_token5' => 'Bitte geben Sie einen gültigen Betrag ein, gefolgt von der Raute-Taste.',
'transfer_token6' => 'Ungültige Kontonummer, bitte geben Sie die Kontonummer erneut ein', // hinzugefügt

'transfer_link_acc1' => 'Ihre registrierten verknüpften Begünstigtenkonten sind',
'transfer_link_accb' => 'Ihre registrierten Begünstigtenkonten sind', // hinzugefügt
'transfer_typeb' => 'Bitte beachten Sie, dass Sie aus Sicherheitsgründen nur auf ein gespeichertes Begünstigtenkonto überweisen können', // hinzugefügt
'transfer_link_accb1' => 'Um diese Begünstigtenkontonummer auszuwählen', // hinzugefügt

'transfer_link_acc2' => 'Um das Überweisungskonto auszuwählen',
'transfer_link_acc3' => 'Drücken',
'transfer_link_acc4' => 'Bitte geben Sie Ihre Begünstigtenkontonummer ein, gefolgt von der Raute-Taste.',
'transfer_link_acc5' => 'Um das Zielkonto für die Überweisung auszuwählen',

'transfer_link_acc6' => 'Begünstigtenkontonummer ist ungültig',
'transfer_link_acc7' => 'Begünstigter Nutzer ist gesperrt',
'transfer_link_acc8' => 'Begünstigter Nutzer ist noch nicht genehmigt.',
'transfer_link_acc9' => 'Währung des Begünstigtenkontos stimmt nicht mit der Währung des Lastschriftkontos überein',
'transfer_link_acc10' => 'Bitte geben Sie Ihr',
'transfer_link_acc11' => 'Die eingegebene Information ist ungültig',
'transfer_link_acc12' => 'Bitte beachten Sie, dass eine Transaktionsgebühr von 0,002% für diese Überweisung anfällt', // hinzugefügt
'transfer_link_acc13' => 'Wir werden diese Gebühren von dem ausgewählten Konto abziehen, bitte drücken Sie 1, um fortzufahren', // hinzugefügt

'transfer_acc_sort1' => 'Geben Sie die Routing-Nummer ein, gefolgt von der Raute-Taste.',
'transfer_acc_sort2' => 'Entschuldigung, ich habe die Routing-Nummer nicht erhalten.',

'transfer_acc_sort3' => 'Diese Kontonummer ist nicht für Überweisungen verknüpft.',
'transfer_acc_sort4' => 'Bitte geben Sie eine registrierte verknüpfte Kontonummer erneut ein, gefolgt von der Raute-Taste.',
'transfer_credit1' => 'Um zum Hauptmenü zurückzukehren, drücken Sie 1',
'transfer_credit2' => 'Zum Beenden legen Sie bitte auf. Vielen Dank.',

'transfer_credit3' => ', Ihre Überweisungsanforderung wurde angenommen',
'transfer_credit4' => 'Der Betrag wurde von Ihrem Konto abgebucht.',
'transfer_credit5' => 'Ihr neues Kontoguthaben beträgt',
'transfer_credit6' => 'Bitte erlauben Sie 1 bis 2 Werktage, bis die überwiesenen Mittel das Begünstigtenkonto erreichen.',

'transfer_credit7' => 'Sie haben einen ungültigen Überweisungstoken-Code eingegeben.',
'transfer_credit8' => 'Bitte geben Sie Ihren 5-stelligen "GEHEIMEN ÜBERWEISUNGSTOKEN-CODE" ein, gefolgt von der Raute-Taste.',

'transfer_credit9' => 'Entschuldigung, ich habe Ihren ÜBERWEISUNGSTOKEN-CODE nicht erhalten',
'dontGetResponse' => 'Entschuldigung, ich habe Ihre Antwort nicht erhalten',
'ExceedLimit' => 'Sie haben das Zeitlimit überschritten. Auf Wiedersehen.',
'invalidInput' => 'Ihre Eingabe ist ungültig, bitte versuchen Sie es erneut',

'handlex3' => 'Für Informationen zu neuen Konten, Produkten und Dienstleistungen, drücken Sie 3',
'handlex4' => 'Für Informationen zu Krediten und Warendepots, drücken Sie 4',

'main3_intro' => 'Willkommen in unserem Produkt- und Dienstleistungsmenü.',
'main3_opt1' => 'Für Produktinformationen, drücken Sie 1',
'main3_opt2' => 'Um mit dem Kundenservice zu sprechen, drücken Sie 2',
'main3_opt0' => 'Um zum Hauptmenü zurückzukehren, drücken Sie 0',
'main3_sub_intro' => 'Bitte wählen Sie ein Produkt aus, um mehr zu erfahren.',
'main3_sub_opt1' => 'Für Informationen zu Sparkonten, drücken Sie 1',
'main3_sub_opt2' => 'Für Kreditinformationen, drücken Sie 2',
'main3_sub_opt3' => 'Für Anlageinformationen, drücken Sie 3',
'main3_sub_opt0' => 'Um zum vorherigen Menü zurückzukehren, drücken Sie 0',
'main3_savings' => 'Unsere Sparkonten bieten wettbewerbsfähige Zinssätze mit einfachem Zugang zu Ihrem Guthaben.',
'main3_loans' => 'Wir bieten eine Reihe von Kreditprodukten, die Ihren Bedürfnissen entsprechen, einschließlich Privat- und Geschäftskrediten.',
'main3_investments' => 'Unsere Anlageprodukte sollen Ihnen helfen, Ihre Ersparnisse im Laufe der Zeit zu vermehren.',

'main4_intro' => 'Willkommen in unserem Kredit- und Warendepotmenü.',
'main4_opt1' => 'Für Kredit- und Rückzahlungsinformationen, drücken Sie 1',
'main4_opt2' => 'Für Informationen zum Warendepot, drücken Sie 2',
'main4_opt0' => 'Um zum Hauptmenü zurückzukehren, drücken Sie 0',
'main4_loans' => 'Bitte wählen Sie eine Option für Kreditinformationen.',
'main4_loans_opt1' => 'Für Ihren Kreditsaldo, drücken Sie 1',
'main4_loans_opt2' => 'Für Rückzahlungsinformationen, drücken Sie 2',
'main4_loans_opt0' => 'Um zum vorherigen Menü zurückzukehren, drücken Sie 0',
'main4_cargo' => 'Für Anfragen zum Warendepot besuchen Sie bitte Ihre nächste Filiale oder kontaktieren Sie den Kundenservice.',
'main4_balance' => 'Ihr aktueller Kreditsaldo wird in Kürze vorgelesen.',
'main4_repayment' => 'Die Details Ihrer nächsten Rückzahlung werden in Kürze vorgelesen.',

        ];
		
		$Array['ja-JP'] = [
		'handle1' =>'Denwa ginkō no roguin jōhō matawa ATM debittokādo bangō o o-mochi no baai wa, 1 o oshite kudasai',
		'handle2' =>'Kasutamākeasapōto ni hanasu ni wa, 2 o oshimasu.',
		'handle3' =>'CUSTOMER ID ni tsudzukete pondokī o nyūryoku shite kudasai',
		'handle4' =>'Tsūwa ga tensō sa rete imasu. Setsuzoku suru made omachikudasai.',
		'handle5' =>"Kon'nichiwa, no kasutamākeasābisu ni o denwa itadaki arigatōgozaimasu",
		'handle6' =>'Tōtatsu shiyou to shite iru bumon no naisen bangō o nyūryoku shite kudasai',
		'handle7' =>"Naisen bangō o o mochi denai baai wa,-ji no riyō kanōna operētā ni setsuzoku suru tame ni kaisen ni todomatte kudasai",
		'handle8' =>'Kono tsūwa wa, hinshitsu to torēningu no mokuteki de kanshi sa reru baai ga aru koto ni chūi shite kudasai',
		'handle9' =>"Kasutamāējento ga mamonaku go an'nai shimasu. Omachikudasai",
		'handle10' =>'Mōshiwakearimasenga, okyakusama no ID o shutoku dekimasendeshita',
		'handle11' =>'Kasutamā tantōsha ga mamonaku anata to issho ni narimasu. Omachikudasai',
		'handle12' => 'Nyūryoku ga mukōdesu',
		'handle_map1'=>"Naisen bangō ga nai baai wa,-ji no riyō kanōna operētā ni setsuzoku suru tame ni kaisen o iji shite kudasai",
		
		'handle_map'=>"Nyūryoku shita kakuchō bangō ga mitsukarimasen. Yūkōna kakuchō bangō de mōichido o tameshi kudasai",
		'handle_map2'=>'Enchō bangō o mōichido nyūryoku shite kudasai',
		
		'customer_id_login1'=>'USER ID ni tsudzukete pondokī o nyūryoku shimasu.',
		'customer_id_login2'=>"Mōshiwakearimasenga, yūzā ID o shutoku dekimasendeshita",
		'customer_id_login3'=>'CUSTOMER ID ga mukōdesu',
		'customer_id_login4'=>'CUSTOMER ID ni tsudzukete pondokī o sai nyūryoku shite kudasai',
		
		'user_id_login1'=>'Anshō bangō o nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		'user_id_login2'=>"Mōshiwakearimasenga, himitsu no pin o shutoku dekimasendeshita.",
		'user_id_login4'=>'Nyūryoku shita yūzā ID ga mukōdesu.',	
		'user_id_login5'=>'USER I D o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		
		'pin_login1'=>'Mōshiwakearimasenga, akaunto ga burokkusareteimasu. Kasutamāsapōto ni go renraku kudasai. Arigatō',
		'pin_login2'=>'Okaerinasai',
		'pin_login3'=>'Akaunto no zandaka o kakunin suru ni wa, 1 o oshimasu',
		'pin_login4'=>'Onrain tensō rikuesuto no baai wa, 2 o oshimasu',
		'pin_login5'=>'4 O oshite, saigo no itsutsu no toranzakushon o kikimasu',
		'pin_login6'=>'5 O oshite akaunto no sutētasu o kakunin shimasu',
		'pin_login7'=>'Kādo no jōtai o kakunin suru ni wa, 6 o oshimasu',
		'pin_login8'=>'Messēji o kiku ni wa, 3 o oshimasu',
		'pin_login10'=>'Anshō bangō o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		'pin_login11'=>'Nyūryoku shita himitsu no pin ga mukōdesu',
		'pin_login12'=>'Anata ga motte iru ',
		'pin_login13'=>'Jushin torei no messēji.',
		
		'Welcome_user2'=>"Mōshiwakearimasenga, akaunto bangō o shutoku dekimasendeshitaNumber.",
		'Welcome_user3'=>'Akaunto bangō ni tsudzukete pondokī o nyūryoku shite kudasai.',
		
		'Welcome_user4'=>'Rōkaru tensō o okonau ni wa, 1 o oshimasu',
		'Welcome_user5'=>'Betsu no ginkō ni sōkin suru ni wa, 2 o oshimasu',
		'Welcome_user51'=>'Jibun no kōza ni sōkin suru ni wa 3 o oshimasu',
		'Welcome_user6'=>'Meinmenyū ni modoru ni wa, sutākī o oshimasu',
		
		'Welcome_user7'=>'Yoshin gendo-gaku ni tsuite wa, 1 o oshite kudasai',

		'Welcome_user8'=>'Kurejitto tensō no baai wa, 2 o oshimasu',
		'Welcome_user9'=>'Kurejittokādoakaunto o rinku suru ni wa, 3 o oshimasu',
		'Welcome_user10'=>'Meinmenyū ni idō shi, sutākī o oshimasu',
		'Welcome_user11'=>'Subete no messēji o sakujo suru ni wa, 2 o oshimasu',
		'Welcome_user12'=>'Nyūryoku ga mukōdesu. Yūkōna nyūryoku o nyūryoku shite kudasai',
		'Welcome_user13'=>'Onrain de seikyū-sho ya sonohoka no tokubetsuna akaunto kinō o shiharau ni wa, 3 o oshimasu',

		'Welcome_user14'=>'Anata wa messēji bangō o kikimasu',
		'Welcome_user15'=>'Anata no sutētasu wa horyū-chūdesu',
		'Welcome_user16'=>'Anata no sutētasu wa shōnin-zumidesu',
		'Welcome_user17'=>'Anata no sutētasu wa ichiji teishi sa rete imasu',
		'Welcome_user18'=>'Anata no sutētasu wa burokkusareteimasu',
		'accout_balance_login1'=>'Kono akaunto no kako 5-kai no torihiki no shōsai',
		'accout_balance_login2'=>'Toranzakushon o mōichido kiku ni wa, sutā o oshimasu. Mein no akauntomenyū ni modoru ni wa, 1 o oshimasu.',
		'accout_balance_login3'=>'Akaunto no taipu:',
		'accout_balance_login4'=>'Akaunto no zandaka wa',
		
		'accout_balance_login5'=>'Akaunto no zandaka o mōichido kiku ni wa, sutā o oshimasu. Mein no akauntomenyū ni modoru ni wa, 1 o oshimasu.',
		'accout_balance_login6'=>'Nyūryoku shita kōza bangō ga mukōdesu',
		'accout_balance_login7'=>'Akaunto bangō o sai nyūryoku shite kudasai',

		'accout_balance_login8'=>'Mukōna nyūryoku o nyūryoku shimashita',
		'transfer_type1'=>'Sekyuriti-jō no riyū kara, hozon sa reta rinku sa reta akaunto ni nomi tensō dekiru koto ni chūi shite kudasai. Onaji tsūka to itchi',
		'transfer_type2'=>"Genzai, rinku sa reta `rōkaruakaunto' wa hozon sa rete imasen. Moyori no shiten ni akusesu shite akaunto o rinku shi, rōkaru tensō o okonatte kudasai.",  
		'transfer_type3'=>'Tensō suru akaunto o sentaku suru ni wa, sutākī o oshimasu',

		'credit_process1'=>'Kurejitto akaunto no zandaka wa',
		'credit_process2'=>'Sarani shori suru ni wa, meinmenyū kara sentaku shite kudasai.',
		'credit_process3'=>'Rinku sa rete iru kurejitto akaunto ga arimasen.',
		'credit_process4'=>'Kurejitto akaunto o rinku suru ni wa meinmenyū kara sentaku shite kudasai.',
		'credit_process5'=>'Tensō o okonau ni wa, kurejittokādo o rinku suru hitsuyō ga arimasu. Riyō kanōna rinku sa reta kādo o kiku ni wa, 1 o oshimasu.',
		'credit_process6'=>'Mērupuresu 1 de rikuesuto o jushin suru ni wa mērupuresu 2 de rikuesuto o jushin suru ni wa',

		'credit_process01'=>'Tsugi no kādo ga rinku sa rete imasu,',
		'credit_process02'=>'Ga arimasu',
		'credit_process03'=>'Kurejittokādo no shita 6-keta o nyūryoku shite kudasai',
		'credit_process04'=>'Kono kādoakaunto wa',
		'credit_process05'=>'Kingaku o nyūryoku shite kudasai',
		'credit_process06'=>'Anata ga oshita',
	    'credit_process07'=>'Nyūryoku shita kono jōhō wa mukōdesu. 6-Keta o sai nyūryoku shite kudasai',
		'credit_process07'=>'Tōkun o nyūryoku shite kudasai',
		'credit_process08'=>'Tensō ga kaishi sa remashita. Kanryō made ni 12 〜 24-jikan o ataemasu',

		'credit_process001'=>'Kingaku ga nokori kingaku o koete iru baai wa, atarashī kingaku o sai nyūryoku shite kudasai',
		'credit_process002'=>'Rikuesutofōmu wa tōroku sa rete iru adoresu ni sōshin sa remashita arigatōgozaimasu',
 	  'credit_process003'=>'Mēru ga kinō shinai',
 	  'credit_process004'=>'Rikuesutofōmu wa tōroku sa rete iru mēruadoresu ni sōshin sa remashita arigatōgozaimasu',

 	  'transfer_acc_amount1'=>'Kono tōroku-zumi akaunto no shōsai wa ni zokushimasu',
 	  'transfer_acc_amount2'=>'Tensō suru kingaku o nyūryoku shite kara, pondokī o nyūryoku shite kudasai.',
 	  'transfer_acc_amount3'=>'Nyūryoku shita tōkun bangō ga mukōdesu.', 
 	  'transfer_acc_amount4'=>'Ginkō kōdo o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
 	  'transfer_token1'=>'Ukeire rareta kingaku',
 	  'transfer_token2'=>'No gōkei o tensō suru yō ni rikuesuto shimashita',
 	'transfer_token4'=>'Zandaka ga fusoku shite iru tame, kingaku wa uketsuke raremasen',
 	 'transfer_token5'=>'Yūkōna kingaku o nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
 	  'transfer_token6'=>'Mukōna akaunto bangō akaunto bangō o sai nyūryoku shite kudasai',
 	 'transfer_link_acc1'=>'Anata no tōroku sa reta rinku sa reta akaunto wa', 
 	 
 	  'transfer_link_accb'=>'Tōroku sa reta uketori hito no akaunto wa ', //newadded
 	 'transfer_typeb'=>'Sekyuriti-jō no riyū kara, hozon sa reta uketori hito no akaunto ni nomi tensō dekiru koto ni chūi shite kudasai ', //newadded
 	 'transfer_link_accb1'=>'Kono uketori hito bangō o sentaku suru ni wa ',//newadded
	
	 'transfer_link_acc2'=>'Akaunto bangō kara no tensō o sentaku suru ni wa',  
	 'transfer_link_acc3'=>'Osu',
	 'transfer_link_acc4'=>'Uketori hito no kōza bangō ni tsudzukete pondokī o nyūryoku shite kudasai.', 
	 'transfer_link_acc5'=>'Akaunto bangō e no tensō o sentaku suru ni wa',

	'transfer_link_acc6'=>'Uketori hito no kōza bangō ga mukōdesu',  
	'transfer_link_acc7'=>'Uketori hito yūzā ga teishi sa remashita',  
	'transfer_link_acc8'=>"Uketori hito yūzā wa mada shōnin sa rete imasen.",  
	'transfer_link_acc9'=>'Uketori hito no kōza tsūka ga Debitto kōza no tsūka to itchi shimasen',
	'transfer_link_acc10'=>'Nyūryoku shite kudasai', 
	'transfer_link_acc11'=>'Mukō o nyūryoku shimashita', 
	'transfer_link_acc12'=>'Ryōkin no hikiotoshi wa, kaku sōkin no 2-pāsentodesu.', 
	'transfer_link_acc13'=>'Kōjo ryōkin no akaunto bangō kara anata o sentaku shite imasu 1 o Osae shite kaunto shite kudasai', // newadded

	 
 	 'transfer_acc_sort1'=>'Ginkō kōdo o nyūryoku shi, tsudzuite pondokī o nyūryoku shimasu',
 	 'transfer_acc_sort2'=>"Mōshiwakearimasenga, ginkō kōdo o shutoku dekimasendeshita.",
 	  'transfer_acc_sort3'=>"Kono akaunto bangō wa tensō-yō ni rinku sa rete imasen.",
 	  'transfer_acc_sort4'=>"Tōroku-zumi no rinku sa reta akaunto bangō o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai",		
 	  'transfer_credit1'=>"Meinmenyū ni modoru ni wa, 1 o oshimasu.",
	 'transfer_credit2'=>"Shūryō suru ni wa, denwa o kitte kudasai. Arigatōgozaimashita.",
	  'transfer_credit3'=>", Anata no tensō rikuesuto wa ni ukeire raremashita",
	  'transfer_credit4'=>"No gōkei wa anata no akaunto kara hikiotosa remasu.",
	  'transfer_credit5'=>"Atarashī akaunto no zandaka wa",
	   'transfer_credit6'=>"Sōkin ga kanzen ni yūkō ni naru made, yaku 1 〜 2 eigyō-bi kakarimasu.",
	   'transfer_credit7'=>"Mukōna tensō tōkunkōdo o nyūryoku shimashita.",
	   'transfer_credit8'=>"5-Keta no `SECRETTRANSFERTOKEN kode' ni tsudzukete, pondokī o nyūryoku shite kudasai",
 
	   'transfer_credit9'=>"Mōshiwakearimasenga, tensō tōkunkōdo o shutoku dekimasendeshita",
		'dontGetResponse' => "Mōshiwakearimasenga, henshin ga arimasen",
		'ExceedLimit' => "Taimuauto seigen o koemashita. Sayōnara."
		];
		
		$Array['pt'] = [
		'handle1' =>'Se você tiver os detalhes de login do seu banco telefônico ou o número do cartão de débito no caixa eletrônico, pressione 1',
		'handle2' =>'Para falar com o atendimento ao cliente, pressione 2.',
		'handle3' =>'Por favor, insira seu CLIENTE I D seguido da chave de libra',
		'handle4' =>'Sua chamada está sendo transferida. Por favor, espere enquanto eu conecto você.',
		'handle5' =>'Olá, obrigado por ligar para o serviço de atendimento ao cliente de',
		'handle6' =>'Por favor, insira o número da extensão do departamento que você está tentando acessar',
		'handle7' =>"se você não tiver o número do ramal, por favor, fique na linha para ser conectado à próxima operadora disponível",
		'handle8' =>'Observe que esta ligação pode ser monitorada para fins de qualidade e treinamento',
		'handle9' =>'Um agente do cliente estará com você em breve. Por favor, espere',
		'handle10' =>'Desculpe, não recebi seu CLIENTE I D',
		'handle11' =>'Um representante do cliente estará com você em breve. Por favor, espere',
		'handle12' => 'Sua entrada é inválida',
		'handle_map1'=>"se você não tem ramal, por favor, fique na linha para ser conectado à próxima operadora disponível",
		
		'handle_map'=>"Não foi possível encontrar o número da extensão que você inseriu, tente novamente com um número de extensão válido",
		'handle_map2'=>'Digite o número da extensão novamente',
		
		'customer_id_login1'=>'Digite seu USER I D seguido da tecla Libra.',
		'customer_id_login2'=>"Desculpe, não recebi seu USER I D",
		'customer_id_login3'=>'O CUSTOMER I D é inválido',
		'customer_id_login4'=>'Por favor, digite novamente seu CLIENTE I D seguido pela chave de libra',
		
		'user_id_login1'=>'Por favor, digite seu PIN SECRETO pessoal, seguido pela chave Libra',
		'user_id_login2'=>"Não recebi seu PIN SECRETO.",
		'user_id_login4'=>'O USER I D inserido é inválido.',	
		'user_id_login5'=>'Digite novamente o seu USER I D, seguido pela tecla Libra',
		
		'pin_login1'=>'Desculpe, sua conta está bloqueada. Entre em contato com o Suporte ao Cliente! obrigado',
		'pin_login2'=>'Bem vindo de volta',
		'pin_login3'=>'Para verificar o saldo da sua conta, pressione1',
		'pin_login4'=>'Para solicitações de transferência online, pressione 2',
		'pin_login5'=>'pressione 4 para ouvir suas últimas 5 transações',
		'pin_login6'=>'pressione 5 para verificar o status da conta',
		'pin_login7'=>'Para verificar o status do cartão, pressione 6',
		'pin_login8'=>'Para ouvir suas mensagens, pressione 3',
		'pin_login10'=>'Digite novamente seu PIN DE SEGREDO PESSOAL, seguido da chave de libra',
		'pin_login11'=>'O PIN SECRETO inserido é inválido',
		'pin_login12'=>'Você tem ',
		'pin_login13'=>'mensagens em sua caixa de entrada.',
		
		'Welcome_user2'=>"Desculpe, não recebi seu NÚMERO DE CONTA.",
		'Welcome_user3'=>'Por favor, insira seu NÚMERO DE CONTA seguido da chave Libra.',
		
		'Welcome_user4'=>'Para fazer uma transferência local, pressione 1',
		'Welcome_user5'=>'Para fazer uma transferência para outro banco, pressione 2',
		'Welcome_user51'=>'Para fazer uma transferência para sua própria conta, pressione 3',
		'Welcome_user6'=>'Para voltar ao MENU PRINCIPAL, pressione a tecla estrela',
		
		'Welcome_user7'=>'para limite de crédito, pressione 1',

		'Welcome_user8'=>'para transferência de crédito, pressione 2',
		'Welcome_user9'=>'Para vincular uma conta de cartão de crédito, pressione 3',
		'Welcome_user10'=>'Vá para o menu principal pressione a tecla estrela',
		'Welcome_user11'=>'Para excluir todas as mensagens, pressione 2',
		'Welcome_user12'=>'sua entrada é inválida, insira uma entrada válida',
	'Welcome_user13'=>'Para pagar contas online e outro recurso especial da conta, pressione 3',

		'Welcome_user14'=>'você escuta o número da mensagem',
		'Welcome_user15'=>'Seu status está pendente',
		'Welcome_user16'=>'Seu status é aprovado',
		'Welcome_user17'=>'Seu status está suspenso',
		'Welcome_user18'=>'Seu status é Bloqueado',
		'accout_balance_login1'=>'Detalhes das últimas cinco transações para esta sua conta',
		'accout_balance_login2'=>'Para ouvir suas transações novamente, pressione estrela. Para voltar ao menu principal da conta, pressione 1',
		'accout_balance_login3'=>'Tipo de conta:',
		'accout_balance_login4'=>'O saldo da sua conta é',
		
		'accout_balance_login5'=>'Para ouvir o saldo da sua conta novamente, pressione estrela. Para voltar ao menu principal da conta, pressione 1',
		'accout_balance_login6'=>'O número da conta que você inseriu é inválidod',
		'accout_balance_login7'=>'Digite novamente o seu número de conta',

		'accout_balance_login8'=>'Você inseriu uma entrada inválida',
		'transfer_type1'=>'Observe que, por razões de segurança, você só pode transferir para uma conta vinculada salva. combinado com a mesma moeda',
		'transfer_type2'=>'No momento, você não tem "Contas locais" vinculadas salvas. Visite a filial mais próxima para vincular uma conta e fazer uma transferência local.',  
		'transfer_type3'=>'Para selecionar uma conta para fazer sua transferência, pressione a tecla estrela',

		'credit_process1'=>'O saldo de sua conta de crédito é',
		'credit_process2'=>'Para continuar o processo, escolha no menu principal.',
		'credit_process3'=>'Você não tem nenhuma conta de crédito vinculada.',
		'credit_process4'=>'Para vincular sua conta de crédito Escolha no menu principal.',
		'credit_process5'=>'Para fazer uma transferência, o cartão de crédito deve estar vinculado; para ouvir os cartões vinculados disponíveis, pressione 1',
		'credit_process6'=>'Para receber um pedido por e-mail, pressione 1, Para receber um pedido por e-mail, pressione 2',

		'credit_process01'=>'Você tem os seguintes cartões vinculados,',
		'credit_process02'=>'você tem um',
		'credit_process03'=>'Insira os últimos 6 dígitos do cartão de crédito',
		'credit_process04'=>'Esta conta de cartão pertence a',
		'credit_process05'=>'Por favor, insira o valor',
		'credit_process06'=>'Você empurrou',
	    'credit_process07'=>'Esta informação inserida não é válida, por favor insira novamente os 6 dígitos',
		'credit_process07'=>'Por favor, insira o token',
		'credit_process08'=>'Sua transferência foi iniciada. Dê 12 a 24 horas para a conclusão',

		'credit_process001'=>'O valor é maior do que o valor restante, insira novamente o novo valor',
		'credit_process002'=>'O formulário de solicitação foi enviado para o endereço registrado. Obrigado',
 	  'credit_process003'=>'Email não está funcionando',
 	  'credit_process004'=>'O formulário de solicitação foi enviado para o endereço de e-mail registrado. Obrigado',

 	  'transfer_acc_amount1'=>'Os detalhes desta conta registrada pertencem a',
 	  'transfer_acc_amount2'=>'Por favor, insira o valor a ser transferido seguido da tecla Libra.',
 	  'transfer_acc_amount3'=>'O número do token inserido é inválido.',  
 	  'transfer_acc_amount4'=>'Digite novamente o número de roteamento, seguido da tecla Libra',
 	  'transfer_link_acc1'=>'Suas contas vinculadas registradas são',  
 	  
 	   'transfer_link_accb'=>'Suas contas de beneficiário registradas são ', //newadded
 	 'transfer_typeb'=>'Observe que, por razões de segurança, você só pode transferir para contas salvas de beneficiário ', //newadded
 	 'transfer_link_accb1'=>'Para escolher este número de beneficiário é ',//newadded
	 
	 
 	 'transfer_link_acc2'=>'Para escolher o número de transferência da conta',  
	 'transfer_link_acc3'=>'pressione',  
	 'transfer_link_acc4'=>'Insira o número da sua conta de beneficiário seguido da chave Libra.',
	 'transfer_link_acc5'=>'Para escolher o número de transferência para conta',
	'transfer_link_acc6'=>'O número da conta do beneficiário é inválido', 
	'transfer_link_acc7'=>'O usuário beneficiário está suspenso',  
	'transfer_link_acc8'=>"O usuário beneficiário ainda não foi aprovado.",
	'transfer_link_acc9'=>'A moeda da conta do beneficiário não corresponde à moeda da conta de débito', 
	'transfer_link_acc10'=>'Por favor insira o seu',
	'transfer_link_acc11'=>'Você digitou inválido', 
	
		'transfer_link_acc12'=>'Observe que o débito para despesas é de 0.002% de cada transferência',
		
		'transfer_link_acc13'=>'Estamos escolhendo o seu número de conta para despesas de dedução, pressione 1 para continuar ', // newadded

 	  'transfer_token1'=>'Quantia Aceita',
 	  'transfer_token2'=>'Você solicitou a transferência da soma de',
 	 'transfer_token4'=>'Quantidade não aceita devido a saldo insuficiente',
 	 'transfer_token5'=>'Insira um VALOR válido seguido da chave de libra',
 	  'transfer_token6'=>'Número de conta inválido, digite novamente o número da conta', 
 	 'transfer_acc_sort1'=>'Digite o número de roteamento, seguido pela tecla Libra',
 	 'transfer_acc_sort2'=>"Desculpe, não recebi o número de roteamento.",
 	  'transfer_acc_sort3'=>"Este número de conta não está vinculado à transferência.",
 	  'transfer_acc_sort4'=>"Digite novamente um número de conta registrado vinculado, seguido da chave Libra",		
 	  'transfer_credit1'=>"Para voltar ao menu principal, pressione 1",
	 'transfer_credit2'=>"Para sair, desligue. Obrigado.",
	  'transfer_credit3'=>", sua solicitação de transferência foi aceita to",
	  'transfer_credit4'=>"A soma de será debitada de sua conta.",
	  'transfer_credit5'=>"O novo saldo da sua conta é",
	   'transfer_credit6'=>"Por favor, aguarde cerca de 1 a 2 dias úteis para que sua transferência tenha efeito total.",
	   'transfer_credit7'=>"Você inseriu um código de Token de transferência inválido.",
	   'transfer_credit8'=>'Digite seu "CÓDIGO DE TOKEN DE TRANSFERÊNCIA SECRETA" de 5 dígitos seguido da tecla Libra.',
 
	   'transfer_credit9'=>"Lamento, mas não recebi o seu CÓDIGO DO TOKEN DE TRANSFERÊNCIA",
		'dontGetResponse' => "Desculpe, não recebi sua resposta",
		'ExceedLimit' => "Você excedeu o seu limite de tempo. Tchau."
		];
		
		$Array['ar'] = [
		'handle1' =>"iidha kanat ladayk tafasil tasjil aldukhul 'iilaa albank alhatifii 'aw raqm bitaqat alkhasm min ATM , fadght 1",
		'handle2' =>"liltahaduth 'iilaa daem khidmat aleumla' , adghut 2.",
		'handle3' =>'alraja iidkhal aleamyl I D alkhasu bik mtbweana bimiftah aljunayh',
		'handle4' =>"ytm tahwil mukalamtak. yrja alaintizar hataa 'aqwam bitawsilik.",
		'handle5' =>"mrhbana , shkrana lak ealaa aitisalik bikhidmat aleumla' fi",
		'handle6' =>"yrja altakarum bi'iidkhal alraqm alddakhilii lilqism aldhy tuhawil alwusul 'iilayh",
		'handle7' =>"'iidha lm yakun ladayk alraqm alddakhilii , falrija' albaqa' ealaa alkhati lilaitisal bialmashghal alttali almatah",
		'handle8' =>"yrja mulahazatan 'anah qad yatimu muraqabat hadhih almukalamat li'aghrad aljawdat waltadrib",
		'handle9' =>"sayakun wakil aleumla' maeak qrybana. aintazar min fadlik",
		'handle10' =>"edhrana , lm 'ahsul ealaa eamilik I D",
		'handle11' =>"sayakun ahd mumathili aleumla' maeak qrybana. aintazar min fadlik",
		'handle12' => 'almudakhalat alkhasat bik ghyr saliha',
		'handle_map1'=>"'iidha lm yakun ladayk tamdid , lidha yrja albaqa' ealaa alkhati litatasil bialmashghal alttali almatah",
		
		'handle_map'=>"edhrana , lm natamakan min aleuthur ealaa alraqm alddakhilii aldhy 'adkhalath , yrja almuhawalat maratan 'ukhraa biastikhdam raqm dakhiliin salih",
		'handle_map2'=>"yrja 'iidkhal alraqm alddakhilii maratan 'ukhraa",
		
		'customer_id_login1'=>'USER ID ni tsudzukete pondokī o nyūryoku shimasu',
		'customer_id_login2'=>"Mōshiwakearimasenga, yūzā ID o shutoku dekimasendeshita",
		'customer_id_login3'=>'CUSTOMER ID ga mukōdesu',
		'customer_id_login4'=>'CUSTOMER ID ni tsudzukete pondokī o sai nyūryoku shite kudasai',
		
		'user_id_login1'=>'Kojin no anshō bangō o nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		'user_id_login2'=>"Mōshiwakearimasenga, himitsu no pin o shutoku dekimasendeshita.",
		'user_id_login4'=>'Nyūryoku shita yūzā ID ga mukōdesu.',	
		'user_id_login5'=>'USER I D o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		
		'pin_login1'=>'Mōshiwakearimasenga, akaunto ga burokkusareteimasu. Kasutamāsapōto ni go renraku kudasai. Arigatō',
		'pin_login2'=>'Okaerinasai',
		'pin_login3'=>'Akaunto no zandaka o kakunin suru ni wa, 1 o oshimasu',
		'pin_login4'=>'Onrain tensō rikuesuto no baai wa, 2 o oshimasu',
		'pin_login5'=>'4 O oshite, saigo no itsutsu no toranzakushon o kikimasu',
		'pin_login6'=>'5 O oshite akaunto no sutētasu o kakunin shimasu',
		'pin_login7'=>'liltahaquq min halat albitaqat , aidghata 6',
		'pin_login8'=>'Messēji o kiku ni wa, 3 o oshimasu',
		'pin_login10'=>'Anshō bangō o sai nyūryoku shite kara, pondokī o nyūryoku shite kudasai',
		'pin_login11'=>'Nyūryoku shita himitsu no pin ga mukōdesu',
		'pin_login12'=>'Anata ga motte iru ',
		'pin_login13'=>'Jushin torei no messēji.',
		
		'Welcome_user2'=>"Mōshiwakearimasenga, akaunto bangō o shutoku dekimasendeshita.",
		'Welcome_user3'=>'Akaunto bangō ni tsudzukete pondokī o nyūryoku shite kudasai.',
		
		'Welcome_user4'=>'Rōkaru tensō o okonau ni wa, 1 o oshimasu',
		'Welcome_user5'=>'Betsu no ginkō ni sōkin suru ni wa, 2 o oshimasu',
		'Welcome_user51'=>"li'iijra' tahwil 'iilaa hisab khasin , aidghata 3",
		'Welcome_user6'=>'Meinmenyū ni modoru ni wa, sutākī o oshimasu',
		
		'Welcome_user7'=>'Yoshin gendo-gaku ni tsuite wa, 1 o oshite kudasai',

		'Welcome_user8'=>'Kurejitto tensō no baai wa, 2 o oshimasu',
		'Welcome_user9'=>'Kurejittokādoakaunto o rinku suru ni wa, 3 o oshimasu',
		'Welcome_user10'=>"aintaqil 'iilaa alqayimat alrayiysiat aidghata ealaa miftah alnajma",
		'Welcome_user11'=>'Subete no messēji o sakujo suru ni wa, o oshimasu2',
		'Welcome_user12'=>'Nyūryoku ga mukōdesu. Yūkōna nyūryoku o nyūryoku shite kudasai',
		'Welcome_user13'=>'Onrain de seikyū-sho ya sonohoka no tokubetsuna akaunto kinō o shiharau ni wa, 3 o oshimasu',

		'Welcome_user14'=>'Anata wa messēji bangō o kikimasu',
		'Welcome_user15'=>'Anata no sutētasu wa horyū-chūdesu',
		'Welcome_user16'=>'Anata no sutētasu wa shōnin-zumidesu',
		'Welcome_user17'=>'Anata no sutētasu wa ichiji teishi sa rete imasu',
		'Welcome_user18'=>'halatk mahzura',
		'accout_balance_login1'=>'Kono akaunto no kako 5-kai no torihiki no shōsai',
		'accout_balance_login2'=>'Toranzakushon o mōichido kiku ni wa, sutā o oshimasu. Mein no akauntomenyū ni modoru ni wa, 1 o oshimasu.',
		'accout_balance_login3'=>'Akaunto no taipu:',
		'accout_balance_login4'=>'Akaunto no zandaka wa',
		
		'accout_balance_login5'=>'Akaunto no zandaka o mōichido kiku ni wa, sutā o oshimasu. Mein no akauntomenyū ni modoru ni wa, 1 o oshimasu',
		'accout_balance_lo gin6'=>'Nyūryoku shita kōza bangō ga mukōdesu',
		'accout_balance_login7'=>'Akaunto bangō o sai nyūryoku shite kudasai',

		'accout_balance_login8'=>'Mukōna nyūryoku o nyūryoku shimashita',
		'transfer_type1'=>"yrja mulahazatan 'anah li'asbab 'amniat , yumkinuk faqat altahwil 'iilaa hisab mrtbt mahfwz. mutatabiqat mae nfs aleamala",
		'transfer_type2'=>"Genzai, rinku sa reta `rōkaruakaunto' wa hozon sa rete imasen. Moyori no shiten ni akusesu shite akaunto o rinku shi, rōkaru tensō o okonatte kudasai.",  
		'transfer_type3'=>"litahdid hisab li'iijra' altahwil , aidghata ealaa miftah alnajma",

		'credit_process1'=>'rasid hisab alaitman alkhasu bik hu',
		'credit_process2'=>'lamazid min aleamaliat yrja alaikhtiar min alqayimat alrayiysiat',
		'credit_process3'=>'lays ladayk hisab aytiman murtabit.',
		'credit_process4'=>"lirbat hisab alaytiman alkhasi bik alraja' alaikhtiar min alqayimat alrayiysiat.",
		'credit_process5'=>"min ajl 'iijra' tahwil , yjb rabt bitaqat alaitiman , lilaistimae 'iilaa albitaqat almurtabitat almutahat , aidghata 1",
		'credit_process6'=>"litalaqiy altalab ean tariq albarid aidghat 1 , litalaqiy altalab ean tariq albarid al'iiliktrunii aidghat 2",

		'credit_process01'=>'ladayk albitaqat alttaliat murtabitat ,',
		'credit_process02'=>'ladayk',
		'credit_process03'=>"alraja' 'iidkhal akhar 6 'arqam fi bitaqat alaitiman",
		'credit_process04'=>"hisab albitaqat hdha yantami 'iilaa",
		'credit_process05'=>'alraja iidkhal almablagh',
		'credit_process06'=>'laqad dafaeat',
	    'credit_process07'=>"hadhih almaelumat alty tama 'iidkhaluha ghyr sahihat , yrja 'iieadat 'iidkhal alstt 'arqam",
		'credit_process07'=>'alraja iidkhal alramz',
		'credit_process08'=>"tama bad' altahwil alkhasi bik. aimnah min 12 'iilaa 24 saeatan li'iikmaliha",

		'credit_process001'=>"almablagh 'akbar min almablagh almutabaqii , yrja 'iieadat 'iidkhal almablagh aljadid",
		'credit_process002'=>"tama 'iirsal namudhaj altalab 'iilaa aleunwan almawjud fi almilafi shkrana lak",
 	  'credit_process003'=>"albarid al'iiliktruniu la yaemal",
 	  'credit_process004'=>"tama 'iirsal namudhaj altalab 'iilaa eunwan albarid al'iiliktrunii almawjud fi almilafi shkrana lak",

 	  'transfer_acc_amount1'=>"tafasil alhisab almusajilat tantami 'iilaa", 
 	  'transfer_acc_amount2'=>'alraja iidkhal almablagh almurad tahwilh mtbweana bimuftah aljanih.',
 	  'transfer_acc_amount3'=>"raqm altawjih aldhy 'adkhalath ghyr salihin.",
 	 'transfer_acc_amount4'=>"alraja' 'iieadat 'iidkhal raqm altawjih , mtbweana bimiftah aljunayh",
 	  'transfer_token1'=>'almablagh almaqbul',
 	  'transfer_token2'=>'laqad talabat tahwil mablagh',
 	 'transfer_token4'=>'almablagh ghyr maqbul laeadam kifayat alrasid',
 	 'transfer_token5'=>"alraja' 'iidkhal mablagh salih mtbweana bimiftah aljunayh",
 	  'transfer_token6'=>"raqm alhisab ghyr sahih yrja 'iieadat 'iidkhal raqm alhisab",
 	  'transfer_link_acc1'=>'hisabatik almurtabitat almusjilat hi',  
 	  
 	   'transfer_link_accb'=>'hisabat almustafid almusajalat alkhasat bik hi ', //newadded
 	 'transfer_typeb'=>'yurjaa mulahazat anah li asbab amniat , la yumkinuk altahwil iilaa iilaa hisabat almustafid almahfuza ', //newadded
 	 'transfer_link_accb1'=>'liaikhtiar raqm almustafid hadha ',//newadded

 	   'transfer_link_acc2'=>'liaikhtiar tahwil min raqm alhisab',  
 	   'transfer_link_acc3'=>'sahafa',  
 	   'transfer_link_acc4'=>"alraja' 'iidkhal raqm hisab almustafid mtbweana bimiftah aljunayh.",
 	   'transfer_link_acc5'=>"liaikhtiar raqm altahwil 'iilaa alhisab",  
 	   'transfer_link_acc6'=>'raqm hisab almustafid ghayr salih', 
 	   'transfer_link_acc7'=>'tama taeliq almustakhdam almustafid',
 	    'transfer_link_acc8'=>"lm yatima almuafaqat ealaa almustakhdam almustafid baed.",  
 	    'transfer_link_acc9'=>'eumlat hisab almustafid la tatatabaq mae eumlat hisab alkhasm', 
 	    'transfer_link_acc10'=>"min fadlik 'udkhil", 
 	    'transfer_link_acc11'=>'adkhalat ghayr salih', 
		'transfer_link_acc12'=>"yrja mulahazatan 'ana alkhasm lilrusum hu 0.002% min kuli eamaliat tahwil", 
 		
		'transfer_link_acc13'=>'nahn nakhtar raqm alhisab alkhasi bik lirusum alkhasm , yurjaa aldaght ealaa 1 lileadi', // newadded

 	 
 	 'transfer_acc_sort1'=>"'udkhul raqm altawjih mtbweana bimiftah aljunayh",
 	 'transfer_acc_sort2'=>"edhrana , lm 'ahsul ealaa raqm altawjih.",
 	  'transfer_acc_sort3'=>"raqm alhisab hdha ghyr mrtbt bialtahwil.",
 	  'transfer_acc_sort4'=>'alraja iieadat iidkhal raqm alhisab almurtabit almusajil , mtbweana bimiftah aljunayh',		
 	  'transfer_credit1'=>"lileawdat iilaa alqayimat alrayiysiat , aidghata ealaa 1",
	 'transfer_credit2'=>"lilkhuruj , yrja qate alaitisal. shukraan jazilana.",
	  'transfer_credit3'=>", tama qabul talab altahwil alkhasi bik iilaa ",
	  'transfer_credit4'=>"sayatimu khasm mablagh min hisabik.",
	  'transfer_credit5'=>"rasid hisabik aljadid hu",
	   'transfer_credit6'=>"yurja alsamah bihawali yawm iilaa yawmayn eamal hataa yatim tafeil altahwil bialkamil.",
	   'transfer_credit7'=>"laqad adkhalat ramz tahwil ghyr salh",
	   'transfer_credit8'=>"alraja' 'iidkhal rmaz ramz alnaql alsuri almukawan min 5 arqam mtbweana bimuftah aljanih",
 
	   'transfer_credit9'=>"edhrana , lm ahsul ealaa ramz altahwil almumiz",
		'dontGetResponse' => "asif , lm yasluni raduk",
		'ExceedLimit' => "laqad tajawazat hadu almuhlat alkhasat bik. wadaeaan."
		];
		


        $Array['it'] = [
    'overdraft' =>'Il tuo conto è attualmente in scoperto',
    'handle1' =>'Se hai i dettagli di accesso al Telefono Bancario o il Numero della Carta di Debito Bancomat, premi 1',
    'handle2' =>'Per parlare con il servizio clienti, premi 2.',
    'handle3' =>'Per favore, inserisci il tuo ID CLIENTE seguito dal tasto Cancelletto',
    'handle4' =>'La tua chiamata viene trasferita. Per favore, attendi mentre ti colleghiamo.',
    'handle5' =>'Ciao, grazie per aver chiamato il servizio Clienti di',
    'handle6' =>'Per favore, inserisci il numero di interno del dipartimento che stai cercando di contattare',
    'handle7' =>'Se non hai il numero di interno, rimani in linea per essere collegato al prossimo operatore disponibile',
    'handle8' =>'Si prega di notare che questa chiamata potrebbe essere monitorata per motivi di qualità e formazione',
    'handle9' =>'Un agente sarà con te a breve. Ti preghiamo di attendere',
    'handle10' =>'Mi dispiace, non ho ricevuto il tuo ID CLIENTE',
    'handle11' =>'Un rappresentante sarà con te a breve. Ti preghiamo di attendere',
    'handle12' => 'Il tuo input non è valido',
    'handle_map1' =>'Se non hai il numero di interno, rimani in linea per essere collegato al prossimo operatore disponibile',
    'no_benefi' =>'Nessun conto beneficiario trovato.',
    'handle_map' => 'Mi dispiace, non riesco a trovare il numero di interno che hai inserito, riprova con un numero di interno valido',
    'handle_map2' => 'Per favore, reinserisci il numero di interno',
    
    'customer_id_login1' => 'Inserisci il tuo ID UTENTE seguito dal tasto Cancelletto.',
    'customer_id_login2' => 'Mi dispiace, non ho ricevuto il tuo ID UTENTE',
    'customer_id_login3' => 'L\'ID CLIENTE è non valido',
    'customer_id_login4' => 'Per favore, reinserisci il tuo ID CLIENTE seguito dal tasto Cancelletto',
    
    'user_id_login1' => 'Per favore, inserisci il tuo PIN SEGRETO personale, seguito dal tasto Cancelletto',
    'user_id_login2' => 'Mi dispiace, non ho ricevuto il tuo PIN SEGRETO.',
    'user_id_login4' => 'L\'ID UTENTE che hai inserito è non valido.',
    'user_id_login5' => 'Per favore, reinserisci il tuo ID UTENTE, seguito dal tasto Cancelletto',
    
    'pin_login1' => 'Mi dispiace, il tuo conto è bloccato. Contatta il Servizio Clienti! Grazie',
    'pin_login2' => 'Bentornato',
    'pin_login3' => 'Per controllare il saldo del tuo conto, premi 1',
    'pin_login4' => 'Per richieste di trasferimento online, premi 2',
    'pin_login5' => 'Premi 4 per ascoltare le ultime 5 transazioni',
    'pin_login6' => 'premi 5 per controllare lo stato del conto',
    'pin_login7' => 'Per controllare lo stato della carta, premi 6',
    'pin_login8' => 'Per ascoltare i tuoi messaggi, premi 3',
    'pin_login9' => 'Premi 7 per controllare il conto beneficiario collegato',
    'pin_login10' => 'Per favore, reinserisci il tuo PIN SEGRETO PERSONALE, seguito dal tasto Cancelletto',
    'pin_login11' => 'Il PIN SEGRETO che hai inserito è non valido',
    'pin_login12' => 'Hai ',
    'pin_login13' => 'messaggi nella tua casella.',
    
    'Welcome_user2' => 'Mi dispiace, non ho ricevuto il tuo NUMERO DI CONTO.',
    'Welcome_user3' => 'Per favore, inserisci il tuo NUMERO DI CONTO seguito dal tasto Cancelletto.',
    
    'Welcome_user4' => 'Per effettuare un trasferimento locale, premi 1',
    'Welcome_user5' => 'Per effettuare un trasferimento verso un altro banco, premi 2',
    'Welcome_user51' => 'Per effettuare un trasferimento al tuo stesso conto, premi 3',
    'Welcome_user6' => 'Per tornare al MENU PRINCIPALE, premi il tasto asterisco',
    
    'Welcome_user7' => 'per il limite di credito, premi 1',
    'Welcome_user8' => 'per il trasferimento di credito, premi 2',
    'Welcome_user9' => 'Per collegare un conto di carta di credito, premi 3',
    'Welcome_user10' => 'Per tornare al menu principale premi il tasto asterisco',
    
    'Welcome_user11' => 'Per eliminare tutti i messaggi, premi 2',
    'Welcome_user12' => 'il tuo input non è valido, per favore inserisci un input valido',
    'Welcome_user13' => 'Per pagare bollette online e altre funzionalità speciali del conto, premi 3',
    
    'Welcome_user14' => 'Per ascoltare il tuo numero di messaggio',
    'Welcome_user15' => 'Il tuo stato è in attesa',
    'Welcome_user16' => 'Il tuo stato è approvato',
    'Welcome_user17' => 'Il tuo stato è sospeso',
    'Welcome_user18' => 'Il tuo stato è bloccato',
    'accout_balance_login1' => 'Ultimi dettagli delle cinque transazioni per questo conto',
    'accout_balance_login2' => 'Per ascoltare di nuovo le tue transazioni premi il tasto asterisco, per tornare al menu principale premi 1',
    'accout_balance_login3' => 'Tipo di conto:',
    'accout_balance_login4' => 'Il tuo saldo conto è',
    'accout_status_suspend1' => 'Stato, il tuo conto è sospeso',
    'accout_status_suspend2' => 'Stato, ',
    'accout_status_suspend3' => 'Questo profilo utente è attualmente disabilitato dall\'accedere a questa funzionalità, per favore visita la tua filiale più vicina per abilitare questa funzionalità nel tuo profilo, e consentirti di effettuare trasferimenti verso altri banchi',
    
    'accout_balance_login5' => 'Per ascoltare nuovamente il tuo saldo conto premi il tasto asterisco, per tornare al menu principale premi 1',
    'accout_balance_login6' => 'Il numero di conto che hai inserito è non valido',
    'accout_balance_login7' => 'Per favore, reinserisci il tuo numero di conto',
    
    'accout_balance_login8' => 'Hai inserito un input non valido',
    'transfer_type1' => 'Si prega di notare che per motivi di sicurezza, puoi trasferire solo a un conto collegato salvato. e deve essere la stessa valuta',
    'transfer_type2' => 'Attualmente non hai "Conti beneficiari" collegati salvati. Si prega di visitare la filiale più vicina per collegare un conto beneficiario, per poter effettuare trasferimenti verso altri banchi.',
    'transfer_type3' => 'Per selezionare un conto per effettuare il tuo trasferimento, premi il tasto asterisco',
    
    'credit_process1' => 'Il tuo saldo conto di credito è',
    'credit_process2' => 'Per ulteriori elaborazioni, scegli dal menu principale.',
    'credit_process3' => 'Non hai alcun conto di credito collegato.',
    'credit_process4' => 'Per collegare il tuo conto di credito, scegli dal menu principale.',
    'credit_process5' => 'Per effettuare un trasferimento il conto della carta di credito deve essere collegato, per ascoltare le carte disponibili collegate premi 1',
    'credit_process6' => 'Per ricevere la richiesta per posta premi 1, per ricevere la richiesta via email premi 2',
    
    'credit_process01' => 'Hai le seguenti carte collegate,',
    'credit_process02' => 'hai una',
    'credit_process03' => 'Per favore, inserisci le ultime 6 cifre della carta di credito',
    'credit_process04' => 'Questo conto carta appartiene a',
    'credit_process05' => 'Per favore, inserisci l\'importo',
    'credit_process06' => 'Hai premuto',
    'credit_process07' => 'Queste informazioni inserite non sono valide, per favore reinserisci le 6 cifre',
    'credit_process07' => 'Per favore, inserisci il token',
    'credit_process08' => 'Il tuo trasferimento è stato avviato. Attendere da 12 a 24 ore per il completamento',
    
   

    'credit_process001' => 'L\'importo è maggiore rispetto al tuo importo rimanente. Per favore, reinserisci un nuovo importo.',
'credit_process002' => 'Il modulo di richiesta è stato inviato all\'indirizzo registrato. Grazie.',
'credit_process003' => 'L\'email non funziona.',
'credit_process004' => 'Il modulo di richiesta è stato inviato all\'indirizzo email registrato. Grazie.',

'transfer_acc_amount1' => 'Questi dettagli dell\'account registrato appartengono a',
'transfer_acc_amount2' => 'Per favore, inserisci l\'importo da trasferire seguito dal tasto Cancelletto.',
'transfer_acc_amount3' => 'Il numero di token inserito non è valido.', // need to change
'transfer_acc_amount4' => 'Per favore, reinserisci il numero di routing, seguito dal tasto Cancelletto.',

'transfer_token1' => 'Importo accettato.',
'transfer_token2' => 'Hai richiesto di trasferire la somma di',

'transfer_token4' => 'Importo non accettato a causa di saldo insufficiente.', // need to change, new spelling is wrong
'transfer_token5' => 'Per favore, inserisci un importo valido seguito dal tasto Cancelletto.',
'transfer_token6' => 'Numero di conto non valido, per favore reinserisci il numero di conto.', // need to add new

'transfer_link_acc1' => 'I tuoi conti beneficiari registrati sono',
'transfer_link_accb' => 'I tuoi conti beneficiari registrati sono ', // new added
'transfer_typeb' => 'Si prega di notare che per motivi di sicurezza, è possibile trasferire solo a un conto beneficiario salvato.', // new added
'transfer_link_accb1' => 'Per scegliere questo numero di conto beneficiario ', // new added

'transfer_link_acc2' => 'Per scegliere il numero di conto da cui trasferire',
'transfer_link_acc3' => 'Premi ',
'transfer_link_acc4' => 'Per favore, inserisci il tuo numero di conto beneficiario seguito dal tasto Cancelletto.',
'transfer_link_acc5' => 'Per scegliere il numero di conto a cui trasferire',

'transfer_link_acc6' => 'Il numero di conto beneficiario non è valido.',
'transfer_link_acc7' => 'L\'utente beneficiario è sospeso.',
'transfer_link_acc8' => 'L\'utente beneficiario non è ancora approvato.',
'transfer_link_acc9' => 'La valuta del conto beneficiario non corrisponde alla valuta del conto di addebito.',
'transfer_link_acc10' => 'Per favore, inserisci il tuo ',
'transfer_link_acc11' => 'Hai inserito un valore non valido.',
'transfer_link_acc12' => 'Si prega di notare che una commissione di transazione dello 0,002% è applicabile a questo trasferimento.', // need to add new
'transfer_link_acc13' => 'Dedurremo queste spese dal numero di conto selezionato, per favore premi 1 per continuare.', // new added

'transfer_acc_sort1' => 'Inserisci il numero di routing, seguito dal tasto Cancelletto.',
'transfer_acc_sort2' => 'Mi dispiace, non ho ricevuto il numero di routing.',

'transfer_acc_sort3' => 'Questo numero di conto non è registrato per il trasferimento.',
'transfer_acc_sort4' => 'Per favore, reinserisci un numero di conto registrato, seguito dal tasto Cancelletto.',
'transfer_credit1' => 'Per tornare al menu principale, premi 1.',
'transfer_credit2' => 'Per uscire, ti preghiamo di riattaccare. Grazie.',

'transfer_credit3' => ", la tua richiesta di trasferimento è stata accettata.",
'transfer_credit4' => 'L\'importo è stato addebitato dal tuo conto.',
'transfer_credit5' => 'Il tuo nuovo saldo è',
'transfer_credit6' => 'Si prega di consentire circa 1-2 giorni lavorativi affinché i fondi trasferiti raggiungano il conto beneficiario.',

'transfer_credit7' => 'Hai inserito un codice di trasferimento token non valido.',
'transfer_credit8' => 'Per favore, inserisci il tuo "CODICE TOKEN DI TRASFERIMENTO SEGRETO" a 5 cifre seguito dal tasto Cancelletto.',

'transfer_credit9' => 'Mi dispiace, non ho ricevuto il tuo CODICE TOKEN DI TRASFERIMENTO.',
'dontGetResponse' => 'Mi dispiace, non ho ricevuto la tua risposta.',
'ExceedLimit' => 'Hai superato il limite di tempo. Arrivederci.',
'invalidInput' => 'Il tuo input non è valido, riprova',

'handlex3' => 'Per informazioni su nuovi conti, prodotti e servizi, premi 3',
'handlex4' => 'Per informazioni su prestiti e depositi merci, premi 4',

'main3_intro' => 'Benvenuto nel nostro menu prodotti e servizi.',
'main3_opt1' => 'Per informazioni sui prodotti, premi 1',
'main3_opt2' => 'Per parlare con il servizio clienti, premi 2',
'main3_opt0' => 'Per tornare al menu principale, premi 0',
'main3_sub_intro' => 'Seleziona un prodotto per saperne di più.',
'main3_sub_opt1' => 'Per informazioni sui conti di risparmio, premi 1',
'main3_sub_opt2' => 'Per informazioni sui prestiti, premi 2',
'main3_sub_opt3' => 'Per informazioni sugli investimenti, premi 3',
'main3_sub_opt0' => 'Per tornare al menu precedente, premi 0',
'main3_savings' => 'I nostri conti di risparmio offrono tassi di interesse competitivi con facile accesso ai tuoi fondi.',
'main3_loans' => 'Offriamo una gamma di prodotti di prestito per soddisfare le tue esigenze, inclusi prestiti personali e aziendali.',
'main3_investments' => 'I nostri prodotti di investimento sono progettati per aiutarti a far crescere i tuoi risparmi nel tempo.',

'main4_intro' => 'Benvenuto nel nostro menu prestiti e depositi merci.',
'main4_opt1' => 'Per informazioni su prestiti e rimborsi, premi 1',
'main4_opt2' => 'Per informazioni sui depositi merci, premi 2',
'main4_opt0' => 'Per tornare al menu principale, premi 0',
'main4_loans' => 'Seleziona un\'opzione per le informazioni sul prestito.',
'main4_loans_opt1' => 'Per il saldo del tuo prestito, premi 1',
'main4_loans_opt2' => 'Per informazioni sui rimborsi, premi 2',
'main4_loans_opt0' => 'Per tornare al menu precedente, premi 0',
'main4_cargo' => 'Per richieste sui depositi merci, visita la tua filiale più vicina o contatta il servizio clienti.',
'main4_balance' => 'Il saldo attuale del tuo prestito verrà letto a breve.',
'main4_repayment' => 'I dettagli del tuo prossimo rimborso verranno letti a breve.',

        ];

		// Twilio requires full BCP-47 locale codes (e.g. "en-US", "it-IT") for the
		// Say/Gather "language" attribute, but the text lookup above still uses the
		// short codes ("en", "it"). Alias them so both forms resolve correctly.
		$Array['en-US'] = $Array['en'];
		$Array['it-IT'] = $Array['it'];

		return $Array[$language][$index];

	}
   
}
