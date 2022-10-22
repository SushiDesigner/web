
message.Text = "Loading Place. Please wait..." 
coroutine.yield() 
game:Load("{{ AssetUrl }}") 

if #"" > 0 then
	visit:SetUploadUrl("")
end

message.Parent = nil

game:GetService("ChangeHistoryService"):SetEnabled(true)

visit:SetPing("{{ ClientPresenceUrl }}", 60)
