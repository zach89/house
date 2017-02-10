<template>
    <div class="data-table">
        <table class="table table-hover table-striped">
            <caption class="text-center">房屋管理</caption>
            <thead>
                <tr>
                    <th v-for="column in columns">{{column}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="house in houses">
                    <td @click="editHouse(house)">{{house.name}}</td>
                    <td>{{house.deposit}}</td>
                    <td>{{house.rent}}</td>
                    <td>{{house.fees}}</td>
                </tr>
            </tbody>
        </table>
        <form class="form form-horizontal" id="form" @submit.prevent="addHouse">
            <fieldset class="text-center">
                <legend>{{house.id ? "修改房屋":"添加房屋"}}</legend>
            </fieldset>
            <div class="form-group">
                <label class="col-md-3 control-label">房号</label>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" required v-model="house.name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">租金</label>
                <div class="col-md-6">
                    <input type="text" name="rent" class="form-control" required v-model="house.rent">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">押金</label>
                <div class="col-md-6">
                    <input type="text" name="deposit" class="form-control" required v-model="house.deposit">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">管理费</label>
                <div class="col-md-6">
                    <input type="text" name="fees" class="form-control" required v-model="house.fees">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">确定</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                houses:[],
                columns:['房号','押金','租金','管理费'],
                house:"",
            }
        },
        created(){
            axios.get('/house/read').then(res =>{
               this.houses = res.data;
            });
            // axios.post('/house/delete').then(res =>{
            //     console.log(res);
            // });

        },
        methods:{
            addHouse(){
                var $this = this;
                if($this.house.id){
                    axios.post('/house/update',$this.house).then(res =>{
                        console.log(res);
                    });
                }else{
                    var formdata = $("#form").serialize();
                    axios.post('/house/create',formdata).then(res =>{
                        $this.houses.push(res.data.house);
                        $this.house = "";
                    });
                }
                // var formdata = new FormData(document.getElementById('form'));
            },
            editHouse(house){
                this.house = house;
            }
        }
    }
</script>
