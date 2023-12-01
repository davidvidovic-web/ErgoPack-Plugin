<table style="width: 600px" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td colspan="2">
                <hr style="width: 600px">
                <p style="font-size: 9pt;"><?php echo esc_html__('Mit freundlichen Grüßen | Best regards','ergo'); ?></p>
                <p style="font-size: 10pt;"><strong><?php echo esc_html($fullname) ?></strong></p>
                <p style="font-size: 9pt; color: #4e4a46"><?php echo $title ?></p>
            </td>
        </tr>
        <tr>
            <td style="width: 455px">
                <table style="width: 455px" cellspacing="0" cellpadding="0" border="0">
                    <?php if( !empty( $phone ) ): ?>
                    <tr>
                        <td style="FONT-SIZE: 9pt; COLOR: #363232" valign="top">
                            <STRONG style="COLOR: #363232">P</STRONG> <?php echo $phone ?>
                        </td>
                    </tr>
                    <?php endif ?>
                    <tr style="">
                        <td style="FONT-SIZE: 9pt; color: #363232" valign="top">
                            <?php if( !empty( $email ) ): ?><STRONG style="COLOR: #363232">E</STRONG>&nbsp;&nbsp;<?php echo esc_html($email) ?> |<?php endif; ?>
                            <a title="" style="COLOR: #363232" href="https://ergopack.de/"><?php echo esc_html__('Website','ergo'); ?></a></td>
                    </tr>
                    <tr>
                        <td style="FONT-SIZE: 9pt; color: #363232" valign="top">
                            <STRONG><?php echo esc_html__('','ergo'); ?>A</STRONG><?php echo esc_html__('Hanns-Martin-Schleyer-Str. 21 | D-89415','ergo'); ?>
                            <?php echo esc_html__('Lauingen/Donau','ergo'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="FONT-SIZE: 9pt; color: #363232" valign="top">
                            &nbsp;
                        </td>
                    </tr>
                    <TR>
                        <TD colspan="2" style="FONT-SIZE: 9pt; color: #3c3c3b; PADDING-BOTTOM: 3px" valign="bottom">
                            <p style="FONT-SIZE: 9pt; ">
                                <a class="socialLink" href="https://www.facebook.com/ErgoPack"><img class=socialLink border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Facebook_Icon.png"></a>
                                &nbsp;
                                <a class="socialLink" href="http://www.youtube.com/user/ErgoPack"><img class=socialLink border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Icon_Youtube.png"></a>
                                &nbsp;
                                <a class="socialLink" href="http://www.linkedin.com/company/ergopack-deutschland-gmbh"><img class=socialLink border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Icon_LinkedIn.png"></a>
                                &nbsp;
                                <a class="socialLink" href="http://www.xing.com/companies/ergopackdeutschlandgmbh"><img class=socialLink border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Icon_Xing.png"></a>
                                &nbsp;
                                <a class="socialLink" href="http://www.instagram.com/ergopack_deutschland"><img class="socialLink" border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Icon_Instagram.png"></a>
                                &nbsp;
                                <a class="socialLink" href="https://twitter.com/ergopack"><img class="socialLink" border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Icon_Twitter.png"></a>
                            </p>
                        </TD>
                    </TR>
                </table>
            </td>
            <td style="width: 145px" align="right" valign="middle">
                <?php
                if (ICL_LANGUAGE_CODE == 'us') { ?>
                    <IMG border="0" width="100" style="width: 100px;" src="https://myergopack.com/wp-content/uploads/2021/06/Logoanimation_ErgoStrap_V_6_Final_158x78.gif">
                <?php } else { ?>
                    <IMG border="0" width="100" style="width: 100px;" src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Logo_Animation_V1.6_5_EmailSignatur.gif">
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="FONT-SIZE: 10pt; HEIGHT: 140px; FONT-FAMILY: Arial; WIDTH: 600px; PADDING-TOP: 15px" valign="top" colspan="2">
                <?php if (ICL_LANGUAGE_CODE == 'us') { ?>
                    <a title="" href="https://www.youtube.com/watch?v=bgEMWMaw6fU"><IMG style="WIDTH: 600px;HEIGHT: 140px;" border=0 width="600" height="140" src="https://myergopack.com/wp-content/uploads/2021/06/210621_Banner-Signatur-US_vf.jpg"></a><BR>
                <?php } elseif (ICL_LANGUAGE_CODE == 'en') { ?>
                    <a title="" href="https://www.youtube.com/watch?v=bgEMWMaw6fU"><IMG style="WIDTH: 600px;HEIGHT: 140px;" border=0 width="600" height="140" src="https://myergopack.com/wp-content/uploads/2021/06/210621_Banner-Signatur-US_vf.jpg"></a><BR>
                <?php } else { ?>
                    <a title="" href="https://www.youtube.com/watch?v=bgEMWMaw6fU"><IMG border=0 src="https://ergopack.de/fileadmin/user_upload/general/CodeTwo/Signatur1/Banner_Signatur_072020_2.jpg"></a><BR>
                <?php } ?>
                <span style="COLOR: #ffffff">.</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="FONT-SIZE: 6pt; WIDTH: 600px" valign="top">
                <span style="FONT-SIZE: 6pt; LINE-HEIGHT: 7pt"><?php echo esc_html__('USt.-IdNr.: DE163176280 ','ergo'); ?> <BR><?php echo esc_html__('Eintragung: Amtsgericht ','ergo'); ?>
                    <?php echo esc_html__('Augsburg HRB 13877 ','ergo'); ?><BR><?php echo esc_html__('Geschäftsführer: Witali Neumann','ergo'); ?> <BR><BR>
                    <?php echo esc_html__('Der
                    Inhalt dieser E-Mail ist vertraulich und enthält möglicherweise
                    Informationen, die ausschließlich für ausgewählte Empfänger, nicht für die
                    Öffentlichkeit bestimmt sind. Falls diese E-Mail nicht an den Empfänger
                    gerichtet ist oder fehlgeleitet wurde, ist der Empfänger verpflichtet,
                    alle Kopien der E-Mail umgehend zu löschen und dies dem Absender
                    anzuzeigen. Die unerlaubte Verwendung, Vervielfältigung oder Verbreitung
                    dieser E-Mail ist strengstens verboten.','ergo'); ?>
                    <BR><BR><?php echo esc_html__('This e-mail may contain
                    confidential and/or privileged information. If you are not the intended
                    recipient (or have received this e-mail by mistake) please notify us and
                    destroy this e-mail. Any unauthorized copying, disclosure or distribution
                    of this e-mail is strictly forbidden.','ergo'); ?></span>
            </td>
        </tr>
    </tbody>
</table>
</BODY></HTML>
