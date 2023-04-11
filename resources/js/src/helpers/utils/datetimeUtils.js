export default{
    convertTimezoneToDatetime(tzValue){
        let tz = new Date(tzValue);
        let y = tz.getFullYear();
        let m = '' + (tz.getMonth() + 1);
        if(m.length < 2) m = '0' + m;
        let d = '' + tz.getDate();
        if(d.length < 2) d = '0' + d;
        let h = '' + tz.getHours();
        if(h.length < 2) h = '0' + h;
        let mi = '' + tz.getMinutes();
        if(mi.length < 2) mi = '0' + mi;
        let s = '00';
        return `${y}-${m}-${d} ${h}:${mi}:${s}`;
    },

    dateTimeVnFormat(datetime){
        let tz = new Date(datetime);
        let y = tz.getFullYear();
        let m = '' + (tz.getMonth() + 1);
        if(m.length < 2) m = '0' + m;
        let d = '' + tz.getDate();
        if(d.length < 2) d = '0' + d;
        let h = '' + tz.getHours();
        if(h.length < 2) h = '0' + h;
        let mi = '' + tz.getMinutes();
        if(mi.length < 2) mi = '0' + mi;
        let s = '00';
        return `${h}:${mi} ngày ${d}/${m}/${y}`;
    },

    addOneDay(dateTime){
        let dateAdd = new Date(dateTime);
        // Lấy ngày cuối tháng của tháng hiện tại
        const lastDayOfMonth = new Date(dateAdd.getFullYear(), dateAdd.getMonth() + 1, 0).getDate();

        // Thêm 1 ngày vào ngày hiện tại
        dateAdd.setDate(dateAdd.getDate() + 1);

        // Kiểm tra xem ngày sau khi thêm 1 ngày có phải là ngày cuối tháng hay không
        if (dateAdd.getDate() > lastDayOfMonth) {
        // Nếu là ngày cuối tháng, tăng tháng lên 1 và đặt ngày về 1
        dateAdd.setMonth(dateAdd.getMonth() + 1);
        dateAdd.setDate(1);
        }

        // Kiểm tra xem ngày sau khi thêm 1 ngày có phải là ngày cuối năm hay không
        if (dateAdd.getMonth() === 0 && dateAdd.getDate() === 1) {
        // Nếu là ngày cuối năm, tăng năm lên 1 và đặt tháng về 1 và ngày về 1
        dateAdd.setFullYear(dateAdd.getFullYear() + 1);
        dateAdd.setMonth(0);
        dateAdd.setDate(1);
        }
        return dateAdd;
    }
}
