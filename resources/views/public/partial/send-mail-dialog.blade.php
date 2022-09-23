<div class="row about-section pt-2">
    <div class="col-md-12 inner-width">
        <div class="page-header"> Send message to the scientist.</div>
        <div class="border"></div>
        <div class="about-section-row">
            <div class="about-section-col">
                <div class="about-form pl-4 pr-4">
                    <form id="query_form" name="query_form" class="query_form" action="{{'/public/member/'.$data['member_id'].'/send-email'}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Name <small>*</small></label>
                                    <input name="reporting_person" class="form-control" type="text"
                                        placeholder="enter your name" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Contact Number <small>*</small></label>
                                    <input name="mobile_num" class="form-control" type="number"  placeholder="Contact number" required>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>E-mail <small>*</small></label>
                                    <input name="email" class="form-control" type="email"  placeholder="e-mail" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Subject <small>*</small></label>
                            <input type="text" name="subject" class="form-control" placeholder="subject"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Message <small>*</small></label>
                            <textarea name="message" class="form-control" rows="7"
                                placeholder="enter your message" required></textarea>
                        </div>
                        <div class="form-group">
                            <a type="submit" id="submit-btn"
                                class="btn btn-success text-white btn-theme-colored btn-flat float-right la la-send"
                                data-loading-text="please wait..."> Send</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .about-section {
        background: #f8f9fa;
        padding: 20px 0;
    }

    .inner-width {
        overflow: hidden;
        padding: 0 20px;
        margin: auto;
        width:750px;
    }

    .page-header {
        font-size: 20px !important;
        text-align: center;
    }

    .about-section h1 {
        text-align: center;
    }

    .about-form {
        font-size: 16px;
    }

    .about strong {
        color: blue;
    }

    .message {
        font-size: 20px;
        margin-top: 30vh;
        color: red;
    }


    .border {
        width: 100%;
        height: 3px;
        background: #e74c3c;
        margin: 15px auto;
    }

    .about-section-row {
        display: flex;
        flex-wrap: wrap;
    }

    .about-section-col {
        flex: 50%;
    }

    .about {
        padding-right: 30px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .about p {
        text-align: justify;
        margin-bottom: 20px;
        font-size: 0.97rem !important;
        line-height: 1.5rem;

    }

    .about a {
        display: inline-block;
        color: #e74c3c;
        text-decoration: none;
        border: 2px solid #e74c3c;
        border-radius: 24px;
        padding: 8px 40px;
        transition: 0.4s linear;
    }

    .about a:hover {
        color: #fff;
        background: #e74c3c;
    }

    .query_form small {
        color: red;
        font-weight: bold;
        font-size: 15px;
    }

 
</style>

<script>
    $('#submit-btn').on('click',function(){
        let data = $('form').serializeArray();
        let form_action = $('form').attr('action');

        $.post(form_action,data,function(response){
            if(response.status == true){
                alert('Email successfully sent !!')
                window.location.href='/public/list-members';
            }else{
                alert(response.msg + ' !!')
            }
        })
            
    })
</script>