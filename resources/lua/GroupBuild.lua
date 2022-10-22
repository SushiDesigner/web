-- MultiplayerSharedScript.lua inserted here ----

-- functions ---------------------------------------
function createText(text, position, parent)
	local textLabel = Instance.new("TextLabel")
	textLabel.Position = UDim2.new(0.5, 0, 0, position)
	textLabel.TextColor = BrickColor.Black()
	textLabel.Text = text
	textLabel.Parent = parent
end

function dismissMessageBox(guiMain)
	guiMain:Remove()
end
function createWelcomeGui(player)
	local guiMain = Instance.new("GuiMain")
	guiMain.Parent = player.PlayerGui
	
	local outerFrame = Instance.new("Frame")
	outerFrame.Position = UDim2.new(0.5, -125, 0.5, -75)
	outerFrame.Size = UDim2.new(0,250,0,150)
	outerFrame.BackgroundColor = BrickColor.new(226)
	outerFrame.Parent = guiMain

	local innerFrame = Instance.new("Frame")
	innerFrame.Position = UDim2.new(0,4,0,4)
	innerFrame.Size = UDim2.new(1,-8,1,-8)
	innerFrame.BackgroundColor = BrickColor.new(1029)
	innerFrame.Parent = outerFrame
	
	local dismissButton = Instance.new("TextButton")
	dismissButton.Position = UDim2.new(0.5,-40, 0, 110)
	dismissButton.Size = UDim2.new(0,80,0,20)
	dismissButton.Text = "Let's Build!"
	dismissButton.BackgroundColor = BrickColor.new(1009)
	dismissButton.TextColor = BrickColor.new(1003)
	dismissButton.MouseButton1Click:connect(function() dismissMessageBox(guiMain) end)
	dismissButton.Parent = innerFrame

	createText("Welcome to Group Building", 15, innerFrame)
	createText("Welcome to Group Building", 15, innerFrame)
	createText("This feature still needs a lot of work, but we", 40, innerFrame)	
	createText("wanted to get it out early to get user feedback.", 55, innerFrame)	
	createText("Please be patient, we're working to improve it.", 80, innerFrame)	
end

function onPlayerAdded(player)
	local characterAdded = player.CharacterAdded:connect(function() 
			createWelcomeGui(player)
			characterAdded:disconnect()
		end)
end
