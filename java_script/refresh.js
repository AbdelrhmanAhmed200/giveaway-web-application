import {display} from "./giveaway_list.js"

var ref = document.getElementById("refresh-btn")
ref.addEventListener("click",function(event){
display();
})