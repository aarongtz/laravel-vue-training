<template>
    <div class="card mt-5 p-5" >

        <div v-if="auth" class="media">
            <div class="media-body">
                <div class="form-inline my-4 w-full comment-container">
                    <img class="rounded-circle mr-3"  src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="">
                    <input v-model="newComment" type="text" class="fomr-control form-control-sm w-90" placeholder="Add a comment">
                    <button @click="addComment" class="btn btn-sm btn-primary ml-2">Comment</button>
                </div>
            </div>
        </div>
        <h4>Comments</h4>
        <hr>

        <Comment v-for='comment in comments.data' :key="comment.id" :comment="comment" :video="video" />

        <div class="media" v-if="isDataFetched">
            <!-- COMMENT -->
            <div class="media-body">
                <div class="comment-container mt-3" v-for="singleComment in dataComments" :key="singleComment.id">
                    <div class="mr-3">
                        <!-- <img v-if="getName(singleComment.id).name" :src="`/public/thumbnail/${getName(singleComment.id).id}.png`" class="rounded-circle mr-1"/> -->
                        <Avatar v-if="getName(singleComment.id).name" :username="getName(singleComment.id).name" :size="30"></Avatar>
                    </div>
                    <div class="div">
                        <h4>{{getName(singleComment.id).name}}</h4>
                        <small>{{singleComment.body}}</small> 
                    </div>
                </div> 
            </div>
        </div>

        

        <div class="text-center" v-if="currentPage < lastPage">
            <button @click="fetchComments" class=" btn btn-success mt-2">load more</button>
        </div>
        
    </div>
</template>

<script>
import Avatar from 'vue-avatar';
import Comment from './comment.vue';

    export default {
        name: "comments",
        components:{Avatar, Comment},
        props:{
            video:{type: Object, required: true, default: ()=>({})},
            channel:{required: true, default: ()=>({})}
        },
        computed:{
            
            auth(){
                return __auth();
            }
            
        },
        data: function(){
            return{
                dataComments: [],
                isDataFetched: false,
                userInf: [],
                page: 1,
                newComment: '',
                comments: {
                    data: []
                },
                currentPage: 1,
                lastPage: 0
            }
        },
        methods:{
            getName: function(id){
                let user = this.userInf.filter((item)=>{
                    
                    return item.comment_id == id;
                })
                if(user[0]){

                    return user[0];
                }
                else{
                    return "    "
                }

            },
            addComment: function(){
                if(!this.newComment){
                    return;
                }

                axios.post(`/comments/${this.video.id}`, {
                    body: this.newComment
                }).then(({data}) => {
                    this.comments = {
                        ...this.comments
                    };

                    this.comments.data = [
                        data,
                        ...this.comments.data
                    ];

                    this.newComment = '';
                });
            },
            fetchComments: function(){
                /*
      
                axios.get(`/videos/${this.video.id}/comments?page=${this.page}`)
                .then((response)=>{
                    
                    let newData = response.data.data.filter(()=>true);
                    const maxPage = response.data.last_page;
                    if(this.page <= maxPage){
                        newData.forEach(item => {
                            this.dataComments.push(item)
                        })
                        this.dataComments.forEach(element => {
                            // 
                            axios.get(`/user/${element.user_id}`).then((res)=>{
                                
                                res.data['comment_id'] = element.id;
                                this.userInf = [
                                    ...this.userInf,
                                    res.data,
                                ];
                                
                            });
                        });
                        
                        this.isDataFetched = true;
                        this.$forceUpdate();
                        this.page++;
                    }

                    if(this.page == maxPage){
                        this.showLoadMoreBtn = false;
                    }
                })*/

                const url = this.comments.next_page_url ? this.comments.next_page_url : `/videos/${this.video.id}/comments`;

                

                axios.get(url).then(({ data }) => {
                    this.comments = {
                        ...data,
                        data: [
                            ...this.comments.data,
                            ...data.data
                        ]
                    }

                    this.lastPage = data.last_page;
                    this.currentPage = data.current_page;
                })
                
            }
        },
        mounted() {
            this.fetchComments();
            console.log('Comments mounted.')
        }
    }
</script>

<style  scoped>
.comment-container{
    display: flex;
    flex-direction: row;
    align-content: left;;
}
.comment-container img{
    width: 50px;
    height: 50px;
}
.rounded-circle{
    width: 50px;
    height: 50px;
}
input{
    width: 70%;
    border: solid gray 1px;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}

</style>
