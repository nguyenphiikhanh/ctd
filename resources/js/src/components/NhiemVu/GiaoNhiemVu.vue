<template>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub">
                                    <router-link :to="{name: 'NhiemVu_List'}">
                                        <a class="back-to" href="#"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
                                    </router-link>
                                </div>
                                <h2 class="nk-block-title fw-normal">Tạo nhiệm vụ Đoàn</h2>
                                <div class="nk-block-des">
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <h4 class="title mb-2 mt-4">Loại nhiệm vụ</h4>
                                    <ul class="custom-control-group">
                                        <li v-for="(option, index) in tieuChi" :key="index" class="col-12">
                                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                                <input v-model="tieuChi_choose" type="radio" :value="option.value" class="custom-control-input 100" name="tieu-chi" :id="`tieuChi-${index}`">
                                                <label class="custom-control-label col-12" :for="`tieuChi-${index}`">{{option.name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-inner" v-if="tieuChi_choose">
                                    <h4 class="title mb-2">Hoạt động</h4>
                                    <ul class="custom-control-group">
                                        <li v-for="(option, index) in noidungDanhGia" :key="index" class="col-12">
                                            <div class="custom-control custom-radio custom-control-pro no-control col-12">
                                                <input v-model="noiDung_choose" type="radio" :value="option.value" class="custom-control-input" name="noidung" :id="`noiDung-${index}`">
                                                <label class="custom-control-label col-12" :for="`noiDung-${index}`">{{option.name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="noiDung_choose" class="card-inner">
                                    <h5 class="title mb-4">Thông tin nhiệm vụ</h5>
                                    <div class="row g-3">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label" >Tên nhiệm vụ</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control"  placeholder="Tên nhiệm vụ" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Thời gian thực hiện</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group">
                                                    <div class="input-group-addon">Từ</div>
                                                    <input type="text" class="form-control" />
                                                    <div class="input-group-addon">Đến</div>
                                                    <input type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-12 mt-1">
                                            <div class="form-group">
                                                <label class="form-label" for="cp1-profile-description">Mô tả</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control form-control-sm quill-basic" placeholder="Mô tả hoạt động"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="card-inner" v-if="noiDung_choose">
                                    <h4 class="title mb-2">Đối tượng nhận</h4>
                                    <ul class="custom-control-group">
                                        <li v-for="(option, index) in khoa" :key="index" class="col-6">
                                            <div class="custom-control custom-radio custom-control-pro no-control col-11">
                                                <input v-model="khoa_choose" type="checkbox" :value="option.id" class="custom-control-input" name="khoa" :id="`khoa-${index}`">
                                                <label class="custom-control-label col-12" :for="`khoa-${index}`">Khoa {{option.name}}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button v-if="isValid" class="btn btn-primary mb-3">Tạo nhiệm vụ</button>
                                </div>
                                </div>
                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .components-preview -->
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
            tieuChi_choose: null,
            tieuChi:[
            {
                value: 1,
                name: "I. Rèn luyện về lý tưởng cách mạng, nhận thức chính trị"
            },
                        {
                value: 2,
                name: "II. Rèn luyện về đạo đức, lối sống, tác phong đoàn viên"
            },
                        {
                value: 3,
                name: "III. Rèn luyện về chuyên môn, nghiệp vụ"
            },            {
                value: 4,
                name: "III. Văn hoá, văn nghệ, thể dục - thể thao"
            },            {
                value: 5,
                name: "V. Ý thức trong xây dựng tổ chức Đoàn"
            }
            ],
            noiDung_choose: null,
            noiDung:[
                {
                    tieuChi: 1,
                    noidungDanhGia: [
                        {
                            value: 1,
                            name: "Tham gia các hoạt động học tập, các buổi sinh hoạt chi đoàn về các Nghị quyết của Đảng, Nghị quyết Đại hội Đoàn các cấp…; tham gia các bài học lý luận chính trị của Đoàn TNCS HCM."
                        },
                         {
                            value: 2,
                            name: "Được tham gia học tập các lớp Đoàn viên ưu tú, bồi dưỡng nhận thức về Đảng, được kết nạp vào Đảng Cộng sản Việt Nam."
                        },
                    ]
                },
                {
                    tieuChi: 2,
                    noidungDanhGia: [
                        {
                            value: 1,
                            name: "Có đóng góp cho tập thể, phục vụ cộng đồng"
                        },
                    ]
                },
                {
                    tieuChi: 3,
                    noidungDanhGia: [
                        {
                            value: 1,
                            name: "Tham gia các hoạt động rèn luyện nghiệp vụ"
                        },
                         {
                            value: 2,
                            name: "Tham gia học tập để nâng cao trình độ chuyên môn, nghiệp vụ, kỹ năng nghề nghiệp "
                        },
                         {
                            value: 3,
                            name: "Tham gia nghiên cứu khoa học"
                        },
                         {
                            value: 4,
                            name: "Học tập, nâng cao trình độ ngoại ngữ, tin học"
                        },
                    ]
                },
                {
                    tieuChi: 4 ,
                    noidungDanhGia: [
                        {
                            value: 1,
                            name: "Tham gia các hoạt động văn nghệ, thể dục, thể thao do Đoàn cấp tổ chức"
                        },
                         {
                            value: 2,
                            name: "Tích cực tham gia các phong trào thể dục thể thao quần chúng tại địa phương, đơn vị."
                        },
                         {
                            value: 3,
                            name: "Tham gia các hoạt động văn hoá khác tại địa phương, đơn vị"
                        },
                         {
                            value: 4,
                            name: "Tham gia các cuộc thi dành cho cá nhân do Đoàn các cấp tổ chức"
                        },
                    ]
                },
                {
                    tieuChi: 5,
                    noidungDanhGia: [
                        {
                            value: 1,
                            name: "Tham dự các buổi sinh hoạt chi đoàn, đóng đoàn phí"
                        },
                         {
                            value: 2,
                            name: "Tham gia các hoạt động tình nguyện, các cuộc vận động do Đoàn các cấp phát động."
                        },
                    ]
                },
            ],
            mota: '',
            khoa_choose: [],
            khoa:[
                {
                    id: 1,
                    name: "Hóa học"
                },
                {
                    id: 2,
                    name: "Công nghệ thông tin"
                },
                {
                    id: 3,
                    name: "Vật lý"
                },
                {
                    id: 4,
                    name: "GD Quốc phòng & An ninh"
                },
                {
                    id: 5,
                    name: "Tâm lý học"
                },
                {
                    id: 6,
                    name: "Giáo dục Công dân"
                },
            ]
        }
    },
    computed:{
        isValid(){
            return this.tieuChi_choose && this.noiDung_choose;
        },
        noidungDanhGia(){
            if(this.tieuChi_choose){
                const noiDung = this.noiDung.find(_item => _item.tieuChi == this.tieuChi_choose);
                return noiDung.noidungDanhGia;
            }
        }
    },
    methods:{

    },

    watch:{
        tieuChi_choose(val){
            this.noiDung_choose = null;
        },
        noiDung_choose(val){
            this.mota = '';
        }

    },
}
</script>

<style scoped>

</style>
