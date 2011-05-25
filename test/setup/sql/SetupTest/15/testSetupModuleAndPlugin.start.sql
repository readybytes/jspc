UPDATE `#__plugins` SET `published`=1, `params`='coreapp=1\ncache=1\nSPS_AvatarWidth=75\nSPS_AvatarHeight=75\nSPS_Length=200\nSPS_Height=25\nSPS_FontSize=3\nSPS_FGColor=9CD052\nSPS_BGColor=FFFFFF\nSPS_SLColor=000000\nSPS_STRColor=FFFFFF\nSPS_ImageDebugMode=0\nshowProfile=1\nSPS_VisibleFeatureNumber=all\n\n'
WHERE `element`='jspc';

UPDATE `#__modules` SET `published`=1,`params`='SPS_Layout=vertical\nSPS_ShowAvatar=1\nSPS_AvatarWidth=100\nSPS_AvatarHeight=100\nSPS_Length=150\nSPS_Height=25\nSPS_FontSize=3\nSPS_FGColor=9CD052\nSPS_BGColor=FFFFFF\nSPS_SLColor=000000\nSPS_STRColor=FFFFFF\nSPS_ImageDebugMode=1\nSPS_VisibleFeatureNumber=all\n\n'
WHERE `module`='mod_jspc';
