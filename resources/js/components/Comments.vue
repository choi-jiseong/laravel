<template>
    <div>
      <div class="form-group mb-3">
        <label class="text-xl font-bold w-full ml-8">댓글</label>
          <input type="text" v-model="comment" name="comment" id="comment" class="ml-6 w-4/6 rounded-3xl border-2 border-gray-200">
          <button type="submit" @click="add" class="bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-2 m-2">등록</button>
      </div>
      <div v-for="c in comments" :key="c.id" class="flex ml-3 mb-2">
          
            <div class="m-auto w-full mb-1">
              <div class="flex flex-col bg-gray-50 max-w-sm shadow-md py-2 px-10 md:px-8 rounded-md">
                <div class="flex flex-col gap-6 md:gap-8">
                  <div class="flex flex-col text-center md:text-left">
                    <div class="font-medium text-lg font-bold text-gray-800">{{ c.name }}</div>
                    <div class="text-gray-500 mb-3 whitespace-nowrap">{{ c.comment }}</div>
                    <div class="flex flex-row gap-4 h-10 text-gray-800 my-auto text-1xl mx-auto md:mx-0">
                      <div class="text-gray-500">{{ c.created_at }}</div>
                          <div v-if="user_id == c.user_id">
                          <button type="submit" @click="destroy(c.id)" class=" ml-20 z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-1 m-1">삭제</button>
                          </div>
                    </div>
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
        user_id : String,
        user_name : String,
        post_id : String,
    },
    data(){
        return {
            comment:'',
            comments: []
        }
    },
    methods:{
        add(){
            axios.post('/api/comments/input', {
                comment:this.comment,
                post_id : this.post_id,
                user_id : this.user_id,
                user_name : this.user_name
            }
        )
        .then((response) => {
            this.comments = response.data;
            console.log(response.data);
            this.comment = ''
        })
        },
        destroy(id){
            axios.delete('/api/comments/delete?id='+id+'&post_id='+this.post_id+'&user_id='+this.user_id)
            .then((response) => {
            this.comments = response.data;
            console.log(response.data);
        })
        }
    },
    mounted(){
        axios.get('/api/comments', {params:{
            post_id : this.post_id
        }})
        .then((response) => {
             console.log(response.data);
            this.comments = response.data;
        })
    }
}
</script>