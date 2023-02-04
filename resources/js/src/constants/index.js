import status from "./status";
import roles from "./roles";
import awards from "./awards";

export default {
    LOAI_HOAT_DONG:{
        HOAT_DONG_NCKH: 1,
        HOAT_DONG_NVSP: 2,
        HOAT_DONG_DOAN: 3,
        HOAT_DONG_KHAC: 4,
    },
    HOAT_DONG:{
        THONG_BA0_KHONG_PHAN_HOI: 1,
        THONG_BAO_C0_PHAN_HOI: 2,
        THONG_BAO_C0_PHAN_HOI_THAM_DU: 3,
        THONG_BAO_C0_PHAN_HOI_THAM_GIA: 4,
        PHAN_THI_OR_TIEU_BAN: 5,
        TB_GUI_DS_THAM_DU: 6,
        TB_GUI_DS_THAM_GIA: 7,
    },

    status,
    roles,
    awards
}
