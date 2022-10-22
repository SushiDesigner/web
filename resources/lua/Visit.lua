-- SingleplayerSharedScript.lua inserted here --

pcall(function() settings().Rendering.EnableFRM = true end)
pcall(function() settings()["Task Scheduler"].PriorityMethod = Enum.PriorityMethod.AccumulatedError end)

game:GetService("ChangeHistoryService"):SetEnabled(false)
pcall(function() game:GetService("Players"):SetBuildUserPermissionsUrl("{{ BaseUrl }}//Game/BuildActionPermissionCheck.ashx?assetId={{ PlaceID }}&userId=%d&isSolo=true") end)

workspace:SetPhysicsThrottleEnabled(true)

local addedBuildTools = false
local screenGui = game:GetService("CoreGui"):FindFirstChild("RobloxGui")

function doVisit()
	message.Text = "Loading Game"
	if {{ IsVisit }} then
		game:Load("{{ AssetUrl }}")
		pcall(function() visit:SetUploadUrl("{{ UploadUrl }}") end)
	else
	    pcall(function() visit:SetUploadUrl("") end)
	end
	

	message.Text = "Running"
	game:GetService("RunService"):Run()

	message.Text = "Creating Player"
	if {{ IsVisit }} then
		player = game:GetService("Players"):CreateLocalPlayer({{ PlayerID }})
		player.Name = [====[{{ PlayerName }}]====]
	else
		player = game:GetService("Players"):CreateLocalPlayer(0)
	end
	player.CharacterAppearance = "{{ PlayerAppearance }}"
	local propExists, canAutoLoadChar = false
	propExists = pcall(function()  canAutoLoadChar = game.Players.CharacterAutoLoads end)

	if (propExists and canAutoLoadChar) or (not propExists) then
		player:LoadCharacter()
	end


	message.Text = "Setting GUI"
	player:SetSuperSafeChat({{ PlayerSSC }})
	pcall(function() player:SetMembershipType(Enum.MembershipType.{{ PlayerMembership }}) end)
	pcall(function() player:SetAccountAge({{ PlayerAge }}) end)
	
	if {{ IsVisit }} then
		message.Text = "Setting Ping"
		visit:SetPing("{{ ClientPresenceUrl }}", 300)
	end
	
end

success, err = pcall(doVisit)

if not addedBuildTools then
	local playerName = Instance.new("StringValue")
	playerName.Name = "PlayerName"
	playerName.Value = player.Name
	playerName.RobloxLocked = true
	playerName.Parent = screenGui
				
	pcall(function() game:GetService("ScriptContext"):AddCoreScript(59431535,screenGui,"BuildToolsScript") end)
	addedBuildTools = true
end

if success then
	message.Parent = nil
else
	print(err)
	if {{ IsVisit }} then
		pcall(function() visit:SetUploadUrl("") end)
	end
	wait(5)
	message.Text = "Error on visit: " .. err
end
