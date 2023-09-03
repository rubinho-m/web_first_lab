document.getElementById("check_button").addEventListener("click", function () {
    const x_arr = document.getElementsByName("x_button");
    const y = document.getElementById("y_input");
    const R_index = document.getElementById("r_select").options.selectedIndex;
    const R_arr = document.getElementById("r_select").options;
    const R = (R_arr[R_index].value)
    let x;
    let flag = false;

    for (let i = 0; i < x_arr.length; i++) {
        if (x_arr[i].checked) {
            x = x_arr[i].value;
            flag = true; // x не пустой
            break;
        }
    }


    if (flag && !isNaN(x) && !isNaN(y.value) && y.value && y.value >= -3 && y.value <= 5) {
        let data = new FormData();
        data.append('x', x);
        data.append('y', y.value);
        data.append('R', R);
        let options = {
            method: 'POST',
            body: data,
        };
        fetch("server_script.php", options).then(response => {
            if (!response.ok) {
                throw new Error('Ошибка HTTP ' + response.status);
            }
            return response.text();
        })
            .then(data => {
                document.getElementById("history_table").innerHTML += data;
                console.log('Ответ от сервера:', data);
            })
            .catch(error => {
                console.error('Произошла ошибка:', error);
            });
    } else {
        alert("Некорректные данные!");
    }


})