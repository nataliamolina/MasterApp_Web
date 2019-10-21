<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
</head>
<body>
    <form action="/payment" method="post" id="pay" name="pay" >
        <fieldset>
            <ul>
                <li>
                    <label for="email">Email</label>
                    <input id="email" name="email" value="test_user_19653727@testuser.com" type="email" placeholder="your email"/>
                </li>
                <li>
                    <label for="cardNumber">Credit card number:</label>
                    <input type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" onselectstart="return false" 
                    onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" 
                    onDrop="return false" autocomplete=off value="4097440000000004"/>
                </li>
                <li>
                    <label for="securityCode">Security code:</label>
                    <input type="text" id="securityCode" data-checkout="securityCode" placeholder="123" onselectstart="return false" 
                    onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off 
                    value="321"/>
                </li>
                <li>
                    <label for="cardExpirationMonth">Expiration month:</label>
                    <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="12" 
                    onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" 
                    onDrag="return false" onDrop="return false" autocomplete=off value="2019"/>
                </li>
                <li>
                    <label for="cardExpirationYear">Expiration year:</label>
                    <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="2015" 
                    onselectstart="return false" onpaste="return false" onCopy="return false" 
                    onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off value="04"/>
                </li>
                <li>
                    <label for="cardholderName">Card holder name:</label>
                    <input type="text" id="cardholderName" data-checkout="cardholderName" placeholder="APRO" value="APRO"/>
                </li>
                <li>
                    <label for="docType">Document type:</label>
                    <select id="docType" data-checkout="docType">
                        <option></option>
                    </select>
                </li>
                <li>
                    <label for="docNumber">Document number:</label>
                    <input type="text" id="docNumber" data-checkout="docNumber" placeholder="12345678"  value="12345678"/>
                </li>
            </ul>
            <input type="hidden" name="paymentMethodId" value="visa"/>
            <input type="submit" value="Pay!" />
        </fieldset>
    </form>
</body>
</html>