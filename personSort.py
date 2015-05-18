#!/usr/local/bin/python
import os

import sys


### Queue Class

class Queue:
    '''A first in, first out (FIFO) queue of items'''

    def __init__ (self):
        '''(Queue) -> NoneType
        Create a new empty queue
        '''
        self.contents = []

    def enqueue (self, new_obj):
        '''(Queue, object) -> NoneType
        Place new_obj at the end of the queue.
        '''
        self.contents.append(new_obj)

    def dequeue (self):
        '''(Queue) -> object
        Remove and return the first object in the queue.
        '''
        return self.contents.pop(0)

    def is_empty(self):
        '''(Queue) -> bool
        Return True iff this queue is empty.
        '''
        return self.contents == []



### Sort Phase

# given partition size
partition_size = 100


# open and read input.txt and find number of lines in the data
file = open('input.txt', 'r')
data = file.readlines()
no_of_lines = len(data)


# find number of temporary files required
if no_of_lines%partition_size == 0:
    no_temp_files = int(no_of_lines/partition_size)
else:
    no_of_temp_files = int(no_of_lines/partition_size) + 1


# Create no_of_temp_files in a queue of temporary files to write 
# partition_size number of lines in each in each file (except last file)
temp_files_queue = Queue()

for i in range(no_of_temp_files):
    file = open('temp' + str(i) + '.txt', 'w')
    temp_files_queue.enqueue(file)


# write partition_size number of lines in each temporary file
# (not necessaily the last temporary file)
list_count = 0
total_count = 0
temp_list = []
list_of_temp_files = []

for line in data:
    temp_list.append(line)
    list_count += 1
    total_count += 1
    if list_count > partition_size or total_count == no_of_lines:
        temp_list.sort()
        file = temp_files_queue.dequeue()
        for line in temp_list:
            file.write(line)
        file.close()
        list_of_temp_files.append(file)
        temp_list = []
        list_count = 0


# Create a priority queue by making the last file the first priority
priority_queue = Queue()
for i in range(no_of_temp_files):
    priority_queue.enqueue('temp' + str(no_of_temp_files -1 - i) + '.txt')



### Merge Phase

# A function that reads and merges two lexicographically sorted files
def read_and_merge(f1, f2):
    '''(str, str) -> NoneType
    Reads files named f1 and f2, creates an output file
    by merging f1 and f2 in lexographical order and deletes 
    files named f1 and f2.
    '''
    # open f1, copy data in l1 and delete f1
    l1 = []
    file1 = open(f1, 'r')
    data = file1.readlines()
    for line in data:
        l1.append(line)
    file1.close()
    os.remove(f1)
    
    # open f2, copy data in l2 and delete f2
    l2 = []
    file2 = open(f2)
    data = file2.readlines()
    for line in data:
        l2.append(line)
    file2.close()
    os.remove(f2)
    
    # open output_file for writing
    output_file = open('output.txt', 'w')
    
    # insert elements in lexicographical order in output_file
    while l1 != [] and l2 != []:
        if l1[0][0:20] < l2[0][0:20]:
            output_file.write(l1[0])
            l1.remove(l1[0])
        else:
            output_file.write(l2[0])
            l2.remove(l2[0])
    l3 = l1 + l2
    for element in l3:
        output_file.write(element)
    output_file.close()


# Merge all the temporary files in the order of priority_queue
# and create one output file
output_file = open('output.txt', 'w')

while not(priority_queue.is_empty()):
    f2 = priority_queue.dequeue()
    read_and_merge('output.txt', f2)
