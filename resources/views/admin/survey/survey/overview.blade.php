@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<?php
function Qustype($type){
    $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
    return $questionTypes[$type];
} ?>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-tip/0.9.1/d3-tip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.min.js"></script>

<link href="{{ asset('assets/css/overview.css') }}" rel="stylesheet" type="text/css" />
<div class="main-content">
    <div class="page-content">
        <!-- Default Report -->
        
        <div class="container-fluid">
            <div class="row">
            <div class="card-container col-md-12">
                    <div class="default-header mt-2">
                        <p><span class="qusNo">Default Report</span></p>
                        <p class="qusName">Explore the data behind your survey responses. Gain a better perspective of your survey data and uncover insights for further planning.</p>
                       
                    </div>
                    <div class="desc-content-1">
                        <div class="grid grid-nogutter row">
                            <div class="col-3 wmb--md">
                                <div class="fx-row fx-ai--start" style="font-family: &quot;Source Sans Pro&quot;;"><svg width="24" height="24" viewBox="0 0 90 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M80.5217 1.60869H9.47826C5.34813 1.60869 2 4.95682 2 9.08695V68.913C2 73.0432 5.34813 76.3913 9.47826 76.3913H80.5217C84.6519 76.3913 88 73.0432 88 68.913V9.08695C88 4.95682 84.6519 1.60869 80.5217 1.60869Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M2 20.3043H88" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M26.3044 10.0217C26.4892 10.0217 26.67 10.0766 26.8237 10.1793C26.9774 10.282 27.0972 10.428 27.168 10.5988C27.2387 10.7696 27.2572 10.9575 27.2212 11.1389C27.1851 11.3202 27.0961 11.4868 26.9653 11.6175C26.8346 11.7482 26.668 11.8373 26.4867 11.8733C26.3054 11.9094 26.1174 11.8909 25.9466 11.8201C25.7758 11.7494 25.6298 11.6296 25.5271 11.4758C25.4244 11.3221 25.3696 11.1414 25.3696 10.9565C25.3696 10.7086 25.4681 10.4708 25.6434 10.2955C25.8187 10.1202 26.0564 10.0217 26.3044 10.0217Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M14.9348 10C15.1197 10 15.3004 10.0548 15.4541 10.1575C15.6078 10.2603 15.7277 10.4062 15.7984 10.5771C15.8692 10.7479 15.8877 10.9358 15.8516 11.1171C15.8155 11.2985 15.7265 11.465 15.5958 11.5958C15.465 11.7265 15.2985 11.8155 15.1172 11.8516C14.9358 11.8877 14.7479 11.8692 14.5771 11.7984C14.4062 11.7277 14.2603 11.6078 14.1575 11.4541C14.0548 11.3004 14 11.1197 14 10.9348C14 10.6869 14.0985 10.4491 14.2738 10.2738C14.4491 10.0985 14.6869 10 14.9348 10Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M37.5217 10.0217C37.7066 10.0217 37.8873 10.0766 38.0411 10.1793C38.1948 10.282 38.3146 10.428 38.3854 10.5988C38.4561 10.7696 38.4746 10.9575 38.4385 11.1389C38.4025 11.3202 38.3135 11.4868 38.1827 11.6175C38.052 11.7482 37.8854 11.8373 37.7041 11.8733C37.5228 11.9094 37.3348 11.8909 37.164 11.8201C36.9932 11.7494 36.8472 11.6296 36.7445 11.4758C36.6418 11.3221 36.5869 11.1414 36.5869 10.9565C36.5869 10.7086 36.6854 10.4708 36.8607 10.2955C37.036 10.1202 37.2738 10.0217 37.5217 10.0217Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M45 63.2894C30.5445 63.2894 18.8261 48.3329 18.8261 48.3329C18.8261 48.3329 30.5445 33.3764 45 33.3764C59.4555 33.3764 71.1739 48.3329 71.1739 48.3329C71.1739 48.3329 59.4555 63.2894 45 63.2894Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M45 57.6956C50.1626 57.6956 54.3478 53.5105 54.3478 48.3478C54.3478 43.1852 50.1626 39 45 39C39.8373 39 35.6522 43.1852 35.6522 48.3478C35.6522 53.5105 39.8373 57.6956 45 57.6956Z" stroke="#63686F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="fx-colum ml--lg">
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--grey mb--xs">Visited</h3>
                                        <div class="fx-row fx-ai--end">
                                            <h1 class="ss-text ss-text__size--jumbo ss-text__weight--bold ss-text__color--black ss-text__family--serif ss-text__line-height--normal" style="font-family: &quot;Source Serif Pro&quot;;">1539</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 wmb--md">
                                <div class="fx-row fx-ai--start" style="font-family: &quot;Source Sans Pro&quot;;"><svg height="24" width="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.60594 19.1941C5.9894 18.7726 4.5126 17.9322 3.32449 16.7578C2.13637 15.5834 1.27896 14.1165 0.83872 12.5049C0.398485 10.8934 0.390997 9.19424 0.817011 7.57888C1.24303 5.96353 2.08748 4.48907 3.26519 3.30423C4.44291 2.11939 5.91225 1.26607 7.52501 0.830319C9.13777 0.394573 10.8369 0.391817 12.4511 0.822328C14.0652 1.25284 15.5373 2.10139 16.7189 3.28241C17.9005 4.46342 18.7497 5.93513 19.1809 7.54909" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M6.8365 14.5002C6.18401 14.041 5.63925 13.4453 5.24001 12.7545C4.84077 12.0637 4.59661 11.2943 4.52448 10.4997C4.45234 9.70507 4.55396 8.90428 4.82227 8.15287C5.09059 7.40146 5.51918 6.71742 6.07831 6.14822C6.63744 5.57902 7.31372 5.13829 8.06022 4.8566C8.80672 4.57492 9.60557 4.45902 10.4013 4.51696C11.1971 4.5749 11.9708 4.80529 12.6686 5.19213C13.3664 5.57898 13.9717 6.11302 14.4425 6.75721" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M18.3933 14.8641L20.5853 12.6721C20.6468 12.6105 20.6911 12.5338 20.7139 12.4498C20.7367 12.3658 20.7371 12.2773 20.7152 12.193C20.6933 12.1088 20.6498 12.0317 20.5889 11.9695C20.5281 11.9072 20.452 11.8619 20.3683 11.8381L9.46531 8.73208C9.3796 8.70762 9.2889 8.70652 9.20262 8.7289C9.11633 8.75127 9.0376 8.79631 8.97457 8.85934C8.91154 8.92237 8.86651 9.0011 8.84413 9.08738C8.82176 9.17367 8.82286 9.26436 8.84731 9.35008L11.9533 20.2501C11.9772 20.3338 12.0225 20.4098 12.0847 20.4707C12.147 20.5315 12.224 20.5751 12.3083 20.597C12.3925 20.6189 12.481 20.6185 12.5651 20.5957C12.6491 20.5729 12.7257 20.5286 12.7873 20.4671L14.8373 18.4181L19.5693 23.1501C19.6158 23.1966 19.6709 23.2336 19.7317 23.2588C19.7924 23.284 19.8575 23.297 19.9233 23.297C19.9891 23.297 20.0542 23.284 20.1149 23.2588C20.1757 23.2336 20.2309 23.1966 20.2773 23.1501L23.1263 20.3011C23.22 20.2073 23.2727 20.0802 23.2727 19.9476C23.2727 19.815 23.22 19.6878 23.1263 19.5941L18.3933 14.8641Z" stroke="#63686F" stroke-linecap="round"></path>
                                    </svg>
                                    <div class="fx-colum ml--lg">
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--grey mb--xs">Started</h3>
                                        <div class="fx-row fx-ai--end">
                                            <h1 class="ss-text ss-text__size--jumbo ss-text__weight--bold ss-text__color--black ss-text__family--serif ss-text__line-height--normal" style="font-family: &quot;Source Serif Pro&quot;;">746</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 wmb--md">
                                <div class="fx-row fx-ai--start" style="font-family: &quot;Source Sans Pro&quot;;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6.99902L11 16.499L6 12.499" stroke="#63686F" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12 23.499C18.3513 23.499 23.5 18.3503 23.5 11.999C23.5 5.64775 18.3513 0.499023 12 0.499023C5.64873 0.499023 0.5 5.64775 0.5 11.999C0.5 18.3503 5.64873 23.499 12 23.499Z" stroke="#63686F" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="fx-colum ml--lg">
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--grey mb--xs">Completed</h3>
                                        <div class="fx-row fx-ai--end">
                                            <h1 class="ss-text ss-text__size--jumbo ss-text__weight--bold ss-text__color--black ss-text__family--serif ss-text__line-height--normal" style="font-family: &quot;Source Serif Pro&quot;;">746</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 wmb--md">
                                <div class="fx-row fx-ai--start" style="font-family: &quot;Source Sans Pro&quot;;"><svg height="24" width="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.5 9.5V5.5H3.5V18.499L8.5 18.5" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M17.5 8.49981V3.49981C17.5 3.2346 17.3946 2.98024 17.2071 2.79271C17.0196 2.60517 16.7652 2.49981 16.5 2.49981H12.052C11.7926 1.90677 11.3659 1.40222 10.8242 1.0479C10.2825 0.693588 9.64929 0.504883 9.002 0.504883C8.35471 0.504883 7.72146 0.693588 7.17976 1.0479C6.63806 1.40222 6.2114 1.90677 5.952 2.49981H1.5C1.23478 2.49981 0.98043 2.60517 0.792893 2.79271C0.605357 2.98024 0.5 3.2346 0.5 3.49981V20.4998C0.5 20.765 0.605357 21.0194 0.792893 21.2069C0.98043 21.3945 1.23478 21.4998 1.5 21.4998H9.5" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M6.5 8.5H11.5" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M6.5 11.5H11.5" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M6.5 14.5H9.5" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M17.5 23.5C20.8137 23.5 23.5 20.8137 23.5 17.5C23.5 14.1863 20.8137 11.5 17.5 11.5C14.1863 11.5 11.5 14.1863 11.5 17.5C11.5 20.8137 14.1863 23.5 17.5 23.5Z" stroke="#63686F" stroke-linecap="round"></path>
                                        <path d="M20.1737 15.7549L17.2687 19.6289C17.2041 19.7148 17.1218 19.7858 17.0274 19.8372C16.933 19.8886 16.8286 19.9191 16.7214 19.9267C16.6142 19.9343 16.5066 19.9187 16.4059 19.8812C16.3052 19.8436 16.2137 19.7848 16.1377 19.7089L14.6377 18.2089" stroke="#63686F" stroke-linecap="round"></path>
                                    </svg>
                                    <div class="fx-colum ml--lg">
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--grey mb--xs">Completion Rate</h3>
                                        <div class="fx-row fx-ai--end">
                                            <h1 class="ss-text ss-text__size--jumbo ss-text__weight--bold ss-text__color--black ss-text__family--serif ss-text__line-height--normal" style="font-family: &quot;Source Serif Pro&quot;;">100.00%</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($question as $key =>$qus)
                <div class="card-container col-md-12">
                    <div class="header mt-2">
                        <p><span class="qusNo">QUESTION {{str_pad($key+1, 2, "0", STR_PAD_LEFT)}}</span> | {{Qustype($qus->qus_type)}}</p>
                        <p class="qusName">{{$qus->question_name}}</p>
                        <?php $totalResponse = \App\Models\SurveyResponse::where(['survey_id'=>$qus->survey_id,'question_id'=>$qus->id])->count();
                        $surveyResponeskip = \App\Models\SurveyResponse::where(['survey_id'=>$qus->survey_id,'question_id'=>$qus->id,'skip'=>'yes'])->count(); ?>
                        <p>Answered <span class="count">{{$totalResponse - $surveyResponeskip}}</span><span class="ansCount"></span>Skipped: <span class="count">{{$surveyResponeskip}}</span></p>
                    </div>
                    <div class="desc-content">
                        <div id="word-cloud"></div>
                    </div>
                </div>
                @endforeach                
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var words = [
        {text: "loperamide", size: 40, count: 14},
        {text: "imodium", size: 30, count: 10},
        {text: "tasectan", size: 20, count: 8},
        {text: "gastrop", size: 15, count: 5},
        {text: "smecta", size: 25, count: 7},
        {text: "pepto", size: 10, count: 3},
        {text: "none", size: 5, count: 2},
        {text: "select", size: 15, count: 6},
        {text: "alternative", size: 10, count: 4},
        {text: "anti", size: 10, count: 4},
        {text: "brand", size: 20, count: 6},
        {text: "choose", size: 10, count: 4},
        {text: "diarocare", size: 15, count: 6},
        {text: "gastropect", size: 20, count: 7},
        {text: "pectrolyte", size: 10, count: 4},
        {text: "didn't", size: 15, count: 6}
    ];

    var width = document.getElementById('word-cloud').offsetWidth;
    var height = document.getElementById('word-cloud').offsetHeight;

    var color = d3.scaleOrdinal(d3.schemeCategory10);

    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0])
        .html(function(event, d) {
            return "This word appears " + event.count + 'time(s) in your responses';
        });

    var layout = d3.layout.cloud()
        .size([width, height])
        .words(words.map(function(d) {
            return {text: d.text, size: d.size, count: d.count};
        }))
        .padding(1)  // Reduced padding to make words closer
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return d.size; })
        .on("end", draw);

    layout.start();

    function draw(words) {
        var svg = d3.select("#word-cloud").append("svg")
            .attr("width", layout.size()[0])
            .attr("height", layout.size()[1])
            .append("g")
            .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")");

        svg.call(tip);

        svg.selectAll("text")
            .data(words)
            .enter().append("text")
            .style("font-size", function(d) { return d.size + "px"; })
            .style("font-family", "Impact")
            .style("fill", function(d, i) { return color(i); })
            .attr("text-anchor", "middle")
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
            })
            .text(function(d) { return d.text; })
            .on('mouseover', tip.show)
            .on('mouseout', tip.hide);
    }
});

</script>     
@include('admin.layout.footer')
@stack('adminside-js')
@stack('adminside-datatable')
