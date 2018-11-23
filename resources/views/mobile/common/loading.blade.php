<style type="text/css">
    .loading-show > .loading > span{
        display: inline-block;
        width: 8px;
        height: 100%;
        border-radius: 4px;
        background: lightgreen;
        -webkit-animation: load 1s ease infinite;
    }
    .loading-show > .loading {
        margin-top: 40%;
    }
    @-webkit-keyframes load{
        0%,100%{
            height: 40px;
            background: lightgreen;
        }
        50%{
            height: 70px;
            margin: -15px 0;
            background: lightblue;
        }
    }
    .loading-show > .loading > span:nth-child(2){
        -webkit-animation-delay:0.2s;
    }
    .loading-show > .loading > span:nth-child(3){
        -webkit-animation-delay:0.4s;
    }
    .loading-show > .loading > span:nth-child(4){
        -webkit-animation-delay:0.6s;
    }
    .loading-show > .loading > span:nth-child(5){
        -webkit-animation-delay:0.8s;
    }

</style>

<div class="loading-show">
    <div class="loading">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>