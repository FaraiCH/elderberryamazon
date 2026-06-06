
function oPSigned(){
    $('form').request('onOpSigned', {data: { value: signature.getSignature()}})
}

function QCSigned(){
    $('form').request('onQCSigned', {data: { value: signature2.getSignature()}})
}

function SuperSigned(){
    $('form').request('onSuoerSigned', {data: { value: signature3.getSignature()}})
}


