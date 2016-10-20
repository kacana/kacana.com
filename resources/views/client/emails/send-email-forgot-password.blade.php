<div style="color:#020621;display:block;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;font-size:16px;height:100%;margin:0;padding:0;width:100%"
     bgcolor="#F7F5F2">

    <table cellpadding="0" cellspacing="0" height="auto"
           style="border:none;border-collapse:collapse;border-spacing:0;margin:0px;padding:0px" width="100%"
           bgcolor="#F7F5F2">
        <tbody>
        <tr valign="top" bgcolor="#F7F5F2">
            <td style="font-size:1px"
                bgcolor="#F7F5F2">
                &nbsp;
            </td>
            <td style="padding:18px" bgcolor="#F7F5F2">
                <table align="center" cellpadding="0" cellspacing="0"
                       width="600"
                       style="color:#020621;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;line-height:24px"
                       bgcolor="#F7F5F2">
                    <tbody>
                    <tr>
                        <td style="padding-bottom:12px;padding-left:18px;padding-right:18px">
                            <a href="{{url()}}" style="color:#2752ff;text-decoration:none" target="_blank">
                                <img alt="Kacana" border="0" height="41" src="http://kacana.com/images/client/homepage/logo.png"
                                        width="180" style="display:block">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px">
                            <div style="background:#fff;border-radius:6px;padding:18px">
                                <p style="color:#020621;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;line-height:24px;margin:0px">
                                    Chào {{$user->name}},</p>
                                <p style="color:#020621;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;line-height:24px;margin:20px 0px 0px">
                                    Bạn quên mật khẩu? Bạn có thể cập nhật lại mật khẩu
                                    <a href="{{url()}}/khach-hang/mat-khau-moi?at={{base64_encode($user->email.'--'.$user->temp_password)}}" style="color:#2752ff;text-decoration:none" target="_blank">
                                        tại đây !
                                    <a>
                                </p>
                                <p style="color:#020621;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;line-height:24px;margin:20px 0px 0px">
                                    Vui lòng cập nhật mật khẩu ngay. Liên kết này sẽ hết hạn trong 1 ngày.</p>
                                <p style="color:#020621;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;line-height:24px;margin:20px 0px 0px">
                                    Nếu bạn không thực hiện việc này, bạn có thể bỏ qua email này một cách an toàn.</p>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </td>
            <td style="font-size:1px" bgcolor="#F7F5F2">
                &nbsp;
            </td>
        </tr>
        <tr  valign="top" bgcolor="#F7F5F2">
            <td  style="font-size:1px" bgcolor="#F7F5F2">
                &nbsp;
            </td>
            <td align="center" style="padding:18px">
                <table cellpadding="0" cellspacing="0" width="460" bgcolor="#F7F5F2">
                    <tbody>
                    <tr>
                        <td align="right" style="height:25px;padding-right:1px;width:25px" valign="top">
                            <a href="https://www.facebook.com/kacanafashion" style="color:#2752ff;text-decoration:none" target="_blank">
                                <img alt="Facebook" height="25" src="https://static.kickstarter.com/assets/emails/facebook-social-a1f64bda2f572b5699b8c469d458ac62998e943b3fa0809aab60d9adfd548c0a.png"
                                        style="height:25px;width:25px" width="25" class="CToWUd">
                            </a>
                        </td>
                        <td align="right" class="m_-1946173206955215854pr2"
                            style="height:25px;padding-right:12px;width:25px" valign="top">
                            <a href="#" style="color:#2752ff;text-decoration:none" target="_blank">
                                <img alt="Twitter" height="25" src="https://static.kickstarter.com/assets/emails/twitter-social-bd29cb4f734ec4c129914434d0a9a2c591c8261af3ebb649946337fcc361678a.png" style="height:25px;width:25px" width="25" class="CToWUd">
                            </a>
                        </td>
                        <td valign="top">
                            <div style="display:inline-block">
                                <p style="color:#3d3d66;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;font-size:12px;line-height:16px;margin:0px;vertical-align:middle">
                                    Kacana ·
                                </p>
                            </div>
                            <div style="display:inline-block">
                                <p style="color:#3d3d66;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;font-size:12px;line-height:16px;margin:0px;vertical-align:middle">
                                    43 Tản đà, Phường 10, Quận 5, Hồ Chí Minh ·
                                </p>
                            </div>
                            <div style="display:inline-block">
                                <p
                                   style="color:#3d3d66;font-family:'Helvetica Neue',Helvetica,Arial,'Liberation Sans',FreeSans,sans-serif;font-size:12px;line-height:16px;margin:0px;vertical-align:middle">
                                    <a href="{{url()}}" style="color:#3d3d66;text-decoration:none" target="_blank">http://kacana.com</a>
                                </p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="font-size:1px" bgcolor="#F7F5F2">
                &nbsp;
            </td>
        </tr>
        </tbody>
    </table>
</div>