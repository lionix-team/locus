export const generateHours = () => {
    let hours = [];
    for (let i = 0; i <= 24; i++) {
        let hour = i + ':00';
        if (i < 10) {
            hour = '0' + hour;
        }
        hours.push(hour);
    }
    return hours;
};
