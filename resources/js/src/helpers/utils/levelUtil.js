export const originLevel = (score) => {
    if(score >= 90 && score <= 100){
        return 'Xuất sắc';
    }
    else if(score >= 80 && score < 90){
        return 'Tốt';
    }
    else if(score >= 65 && score < 80){
        return 'Khá';
    }
    else if(score >= 50 && score < 65){
        return 'Trung bình';
    }
    else if(score >= 35 && score < 50){
        return 'Yếu';
    }
    else return 'Kém';
}

export const exceptOneLevel = (score) => {
    if(score >= 90 && score <= 100){
        return 'Tốt';
    }
    else if(score >= 80 && score < 90){
        return 'Khá';
    }
    else if(score >= 65 && score < 80){
        return 'Trung bình';
    }
    else if(score >= 50 && score < 65){
        return 'yếu';
    }
    // else if(score >= 35 && score < 50){
    //     return 'Yếu';
    // }
    else return 'Kém';
}
