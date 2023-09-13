document.addEventListener('DOMContentLoaded', function() {
    reloadTable();
    y_choose_input.classList.add("green-bg");
});

let y_choose_input = document.getElementById("y_input");

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


    if (flag && !isNaN(x) && !isNaN(y.value) && y.value && y.value > -3 && y.value < 5) {
        let data = new FormData();
        data.append('x', x);
        data.append('y', y.value);
        data.append('R', R);
        let options = {
            method: 'POST',
            body: data,
        };

        y_choose_input.classList.remove("red-bg");
        y_choose_input.classList.add("green-bg");

        fetch("server_script.php", options).then(response => {
            if (!response.ok) {
                throw new Error('Ошибка HTTP ' + response.status);
            }
            return response.text();
        })
            .then(data => {
                let table = localStorage.getItem("table");
                if (table === null){
                    localStorage.setItem("table", data);
                } else {
                    let rows = table.split(",");
                    rows.push(data);
                    localStorage.setItem("table", rows.join(","));
                }
                reloadTable();
            })
            .catch(error => {
                console.error('Произошла ошибка:', error);
            });
    } else {
        let error_text = "";
        if (!flag){
            error_text = "Нет значения x";
        }

        else if (!y.value){
            error_text = "Нет значения y";
            y_choose_input.classList.remove("green-bg");
            y_choose_input.classList.add("red-bg");
        } else if (y.value <= -3 || y.value >= 5){
            error_text = "Неправильный диапазон y";
            y_choose_input.classList.remove("green-bg");
            y_choose_input.classList.add("red-bg");
        } else {
            error_text = "Значение y должно быть числом";
            y_choose_input.classList.remove("green-bg");
            y_choose_input.classList.add("red-bg");
        }
        Toastify({
            text: error_text,
            duration: 2000,
            style: {
                background: "red"
            },
            offset: {
                x: 0,
                y: 0
            }
        }).showToast();
    }


})


function reloadTable(){
    clearVisibleTable();
    let table = document.getElementById("history_table");
    let tableStorage = localStorage.getItem("table");
    if (tableStorage){
        let rows = tableStorage.split(",");
        rows.forEach(row => table.insertAdjacentHTML('beforeend', row));
    }

}

function clearVisibleTable(){
    let table = document.getElementById("history_table");

    while (table.rows.length > 1) {
        table.deleteRow(1);
    }
}

function clearTable(){
    localStorage.removeItem("table");
    clearVisibleTable();
}

document.getElementById("clear_button").addEventListener("click", clearTable);
