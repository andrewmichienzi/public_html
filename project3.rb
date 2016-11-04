#!/usr/bin/ruby
$PAGESIZE = 512
$TEXTTYPE = 'Text'
$DATATYPE = 'Data'


#
#	Main
#
$memory = Memory.new
$memory.initialize()
puts('hey there')

#
#	Page Table Class
#
class PageTable
	def initialize(id, textSize, dataSize)
		@id = id
		@textSize = textSize
		@dataSize = dataSize
		self.createTable()
		self.addToMemory()
	end		
	def createTable()
		numOfTextPages = @textSize/$PAGESIZE
		numOfDataPages = @dataSize/$PAGESIZE
		@numTotalPages = numOfTextPages + numOfDataPages
		@textTable = Table.new
		@textTable.initialize(@id, $TEXTTYPE, numOfTextPages)
		
		@dataTable = Table.new
		@dataTable.initialize(@id, $TEXTTYPE, numOfDataPages)
	end
end

#
#	Table Class
#
class Table
	def initialize(id, type, pagesNum)
		@type = type
		@pagesNum = pagesNum
		@id = id
		self.createTable()
	end
	def createTable()
		i = 0
		@pages = Array(0..@pagesNum)
		@frames = Array.new(@pagesNum)
	end
	def addTableToMemory()
		i = 0
		while i < pagesNum
			frame = $memory.addPage(id, type, i)
			@frames.at(i) = frame
			i += 1
		end
	end
end


#
# 	Memory Class
#
class Memory
	def initialize()
		@frames = Array(0..7)
		@ids = Array.new(8, -1)
		@segments = Array.new(8, -1)
		@pageNums = Array.new(8, -1)		
	end
	def addPage(id, segment, pageNum)
		frame = self.getNextEmptyFrame()
		@ids.at(frame) = id
		@segments.at(frame) = segment
		@pageNum.at(frame) = pageNum
		return frame
	end
	def getNextEmptyFrame()
		i = 0
		while @ids.at(i) != -1
			i+=1
		end
		return i
	end
	def printMemory()
		puts('Frame#\tProcID\tSegment\tPage#')
		
	end
end
