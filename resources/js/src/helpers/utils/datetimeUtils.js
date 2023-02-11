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
    }
}
