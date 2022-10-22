
-- Setup studio cmd bar & load core scripts

pcall(function() game:GetService("InsertService"):SetFreeModelUrl("{{ BaseUrl }}/Game/Tools/InsertAsset.ashx?type=fm&q=%s&pg=%d&rs=%d") end)
pcall(function() game:GetService("InsertService"):SetFreeDecalUrl("{{ BaseUrl }}/Game/Tools/InsertAsset.ashx?type=fd&q=%s&pg=%d&rs=%d") end)

game:GetService("ScriptInformationProvider"):SetAssetUrl("{{ BaseUrl }}/Asset/")
game:GetService("InsertService"):SetBaseSetsUrl("{{ BaseUrl }}/Game/Tools/InsertAsset.ashx?nsets=10&type=base")
game:GetService("InsertService"):SetUserSetsUrl("{{ BaseUrl }}/Game/Tools/InsertAsset.ashx?nsets=20&type=user&userid=%d")
game:GetService("InsertService"):SetCollectionUrl("{{ BaseUrl }}/Game/Tools/InsertAsset.ashx?sid=%d")
game:GetService("InsertService"):SetAssetUrl("{{ BaseUrl }}/Asset/?id=%d")
game:GetService("InsertService"):SetAssetVersionUrl("{{ BaseUrl }}/Asset/?assetversionid=%d")

pcall(function() game:GetService("SocialService"):SetFriendUrl("{{ BaseUrl }}/Game/LuaWebService/HandleSocialRequest.ashx?method=IsFriendsWith&playerid=%d&userid=%d") end)
pcall(function() game:GetService("SocialService"):SetBestFriendUrl("{{ BaseUrl }}/Game/LuaWebService/HandleSocialRequest.ashx?method=IsBestFriendsWith&playerid=%d&userid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupUrl("{{ BaseUrl }}/Game/LuaWebService/HandleSocialRequest.ashx?method=IsInGroup&playerid=%d&groupid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupRankUrl("{{ BaseUrl }}/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRank&playerid=%d&groupid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupRoleUrl("{{ BaseUrl }}/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRole&playerid=%d&groupid=%d") end)

local result = pcall(function() game:GetService("ScriptContext"):AddStarterScript({{ StarterScriptID }}) end)
if not result then
  pcall(function() game:GetService("ScriptContext"):AddCoreScript({{ StarterScriptID }},game:GetService("ScriptContext"),"StarterScript") end)
end
