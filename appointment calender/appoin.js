document.addEventListener('DOMContentLoaded', function () {
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    const appointments = [
        { date: '2024-01-03', time: '09:00 AM', patient: 'John cena'},
        { date: '2024-09-08', time: '02:00 PM', patient: 'Under taker' },
        { date: '2024-09-05', time: '11:00 AM', patient: 'Ricky pointing' },
        { date: '2024-01-15', time: '01:00 PM', patient: 'Brett Lee' },
        { date: '2024-09-26', time: '10:00 AM', patient: 'Steven Gerrad' }
    ];

    function updateCalendar(year, month) {
        const monthYear = document.getElementById('month-year');
        const calendarBody = document.getElementById('calendar-body');
        monthYear.textContent = `${monthNames[month]} ${year}`;
        calendarBody.innerHTML = '';

        let firstDay = new Date(year, month).getDay();
        let daysInMonth = new Date(year, month + 1, 0).getDate();

        let date = 1;
        for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');
            for (let j = 0; j < 7; j++) {
                let cell = document.createElement('td');
                if (i === 0 && j < firstDay) {
                    cell.innerHTML = '';
                } else if (date > daysInMonth) {
                    break;
                } else {
                    cell.textContent = date;
                    let filteredAppointments = appointments.filter(appt => new Date(appt.date).getDate() === date && new Date(appt.date).getMonth() === month);
                    if (filteredAppointments.length > 0) {
                        let list = document.createElement('ul');
                        filteredAppointments.forEach(appt => {
                            let listItem = document.createElement('li');
                            listItem.textContent = `${appt.time} - ${appt.patient}`;
                            list.appendChild(listItem);
                        });
                        cell.appendChild(list);
                    }
                    date++;
                }
                row.appendChild(cell);
            }
            calendarBody.appendChild(row);
        }
    }

    document.getElementById('prev-month').addEventListener('click', function () {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        updateCalendar(currentYear, currentMonth);
    });

    document.getElementById('next-month').addEventListener('click', function () {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        updateCalendar(currentYear, currentMonth);
    });

    updateCalendar(currentYear, currentMonth);
});
