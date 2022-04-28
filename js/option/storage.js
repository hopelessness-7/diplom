function getDateFromPars() {
    dateFrom = document.getElementById('date1').value;
    let newDate = new Date(dateFrom),
    month = '' + (newDate.getMonth() + 1),
    day = '' + newDate.getDate(),
    year = newDate.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');            
}

function getDateBackPars() {
    dateFrom = document.getElementById('date2').value;
    let newDate = new Date(dateFrom),
    month = '' + (newDate.getMonth() + 1),
    day = '' + newDate.getDate(),
    year = newDate.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function storage() {

    let from = document.getElementById('from').value;
    let to = document.getElementById('to').value;
    let date1 = document.getElementById('date1').value;
    let date2 = document.getElementById('date2').value;
    let passengers = document.getElementById('passengers').value;

    localStorage.removeItem('from');
    localStorage.removeItem('to');
    localStorage.removeItem('date1');
    localStorage.removeItem('date2');
    localStorage.removeItem('passengers');

    localStorage.setItem('from',from);
    localStorage.setItem('to',to);
    localStorage.setItem('date1', date1);
    localStorage.setItem('date2', date2);
    localStorage.setItem('passengers', passengers);
}

function namef(code){
    console.log(code);
    localStorage.removeItem('code');
    localStorage.setItem('code',code);

    let codeAll = document.querySelectorAll('.bookingCode')
    localStorage.removeItem('codeAll');
    
    let arrowCode = [];
    for (var i = 0; i < codeAll.length; i++) { // перебираем все столбцы
        console.log(codeAll[i].textContent); // выводим текст из столбца
        arrowCode [i] =  codeAll[i].textContent;
        localStorage.setItem('codeAll', JSON.stringify(arrowCode));
    }
}