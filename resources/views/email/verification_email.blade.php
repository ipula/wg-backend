<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shayint</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=GFS+Didot" rel="stylesheet">

    <style>
        @media (max-width: 768px) {
            .para{
                padding: 0px 13px 30px 13px !important;
            }
        }
    </style>
</head>

<body style=" margin:0px;font-family: 'Lato', sans-serif;">

<div class="box" style="background-color: #f6f6f6; width: 100%; max-width: 800px; margin: 85px auto;">
    <div class="box-img" style="text-align: center;">
        <img src="{{asset('assets/images/logo1@2x.png')}}" style="width: 100px;margin-top: -50px">
    </div>
    <div class="para" style="padding: 0 125px 50px 125px;">
        <p style="text-align: center; font-size: 23px; font-family: 'GFS Didot', serif;">Verify Your Shay-int Account</p>
        <p style="font-size: 18px;">Hi {{$email}},</p>
        <p style="font-size: 13px; color: #797979;">
            Lorem ipsum dolor sit amet, mollis purus magnis posuere amet. Magnis a tell us,metus lectus erat
            tincidunt, id eros metus arcu elit vel ligula, sem a fusce molestie lacus aenean etiam, ut id vitae.
            In nec quis est donec sem, vitae sed sollicitudin massa cars. At fusce scelerisque, non eros non
            repellat, odio nonummy quam nunc penatibus purus varius.
        </p>
        <p style="font-size: 13px; margin-top: 25px; color: #797979;margin-bottom: 30px;">
            Arcu curabitur bibendum vestibulum nam, lobortis quis eu, donce euismod convallis ipsum sapien,
            porttitor vel enim suspendisse.
        </p>
        <div class="btn">
            To verify your details,use this<a href="{{$base_url}}verify/{{$token}}" style="background-color: black;color: #f4f4f4;padding: 8px 15px;border: none;margin-top: 20px;font-size: 11px;text-decoration: none;">Verify Account</a>.<br/>
        </div>
        <div class="thnk" style="font-size: 16px; font-weight: normal; margin-top: 26px;">
            <p style="margin-bottom: 0px;">Thank you!,</p>
            <p style="margin:0px;">Shay-int team</p>
        </div>
    </div>
</div>

</body>

</html>
