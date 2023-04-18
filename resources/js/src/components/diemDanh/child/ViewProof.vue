<template>
    <div class="modal fade modal-lg" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" id="viewProofModal">
        <div class="modal-dialog modal-dialog-top mw-80" role="document">
            <div class="modal-content mh-90">
                <a @click="closeModal()" class="close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header"><h5 class="modal-title">Xem minh chứng</h5></div>
                <div class="modal-body">
                    <div class="col-12" >
                        <div id="proofCarosel" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li v-for="proof, index in prooves" :key="index" data-bs-target="#proofCarosel" :data-bs-slide-to="index" :class="index == 0 ? 'active' : ''"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div v-for="proof, index in prooves" :key="index" :class="`carousel-item ${index == 0 ? 'active' : ''}`">
                                    <img :src="proof.file_path" class="d-block w-100 obj-fit-cover" alt="minh chứng">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#proofCarosel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#proofCarosel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props:{
        prooves: {type: Array, default: []},
    },
    methods:{
        closeModal(){
            this.$emit('onClose')
        }
    },
    computed:{
    },
}
</script>

<style scoped>
.mw-80{
    min-width: 80%;
}
.mh-90{
    min-height: 800px;
}
.obj-fit-cover{
    object-fit: contain;
    max-height: 800px;
    min-height: 800px;
}
</style>
