# ArrayColletction

# getValue
`getValue(): array` - get value of collection as array
# count
`count(): int` - get amount of elements
# map
`map(callable $callback): ArrayCollection`  - applies the callback to the elements of collection
# filter
`filter(callable $callback, string $passedParams = "value"): ArrayCollection`  - filters elements of a collection using a callback function
##### params
 _flag_ - determining what arguments are sent to callback:
 "key" - pass key as the only argument to callback instead of the value.
 _"both"_ - pass both value and key as arguments to callback instead of the value
 Default is "value" which will pass value as the only argument to callback instead._
# chunk
`chunk(int $size, bool $preserveKeys = false): ArrayCollection`  - split collection into chunks
##### params
 _size_ - The size of each chunk:
_preserve_keys_ - When set to **TRUE** keys will be preserved. Default is **FALSE** which will reindex the chunk numerically
# fill
`fill(int $value, int $count, int $startKey = 0): ArrayCollection` - Fill colltction with values
##### params
_value_ - Value to use for filling
_count_ - Number of elements to insert. Must be greater than or equal to zero.
_startKey_ - The first index of the returned collection. If **startKey** is negative, the first index of the returned collection will be start_index and the following indices will start from zero
# intersect
`intersect(iterable ...$collections): ArrayCollection` -  Computes the intersection of iterables
# isKeyExist
`isKeyExist(mixed $key): bool` -  Checks if the given key or index exists in the array
# diff
` diff(array ...$arrays): ArrayCollection` - Computes the difference of arrays
# randKey
`randKey(int $num = 1): mixed`  - Pick one or more random keys out of collection
# randElem
`randElem(int $num = 1): mixed`  - Pick one or more random keys out of collection
##### params
_num_ - Specifies how many entries should be picked.
# printAsString
`printAsString(): ArrayCollection` - display collection in format _key: value'
# reduce
`reduce(callable $callback, $initial = NULL): mixed` - Iteratively reduce the collection to a single value using a callback function
##### params
_callback ( mixed $carry , mixed $item ) : mixed_
* ***carry***
Holds the return value of the previous iteration; in the case of the first iteration it instead holds the value of initial.

* ***item***
Holds the value of the current iteration.*

_initial_ - If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
# reverse
`reverse(bool $preserveKeys = false): ArrayCollection` - Return an collection with elements in reverse order
##### params
_preserveKeys _- If set to TRUE numeric keys are preserved. Non-numeric keys are not affected by this setting and will always be preserved.
# search
`search($needle, $strict = false): mixed` - Searches collection for a given value and returns the first corresponding key if successful
##### params
_needle_ - The searched value.
_strict_ - If the third parameter strict is set to **TRUE** then the search() function will search for identical elements in the haystack. This means it will also perform a strict type comparison of the needle in the haystack, and objects must be the same instance.
# searchAll
`searchAll($needle): mixed` - Searches the collection for a given value and returns collection of keys if successful
# unique
`unique(int $sort_flags = SORT_STRING): ArrayCollection` - Removes duplicate values from collection
##### params
_sort_flags_ - The optional second parameter sort_flags may be used to modify the sorting behavior using these values:

Sorting type flags:
* **SORT_REGULAR** - compare items normally (don't change types)
* **SORT_NUMERIC** - compare items numerically
* **SORT_STRING** - compare items as strings
* **SORT_LOCALE_STRING** - compare items as strings, based on the current locale.
# rsort
`rsort(bool $saveKeys = false, $sort_flags = SORT_REGULAR): ArrayCollection`-  Sort a collection in reverse order and maintain index association
##### params
_saveKeys_  - save keys of original collection
_sort_flags_ - You may modify the behavior of the sort using the optional parameter sort_flags,
# sort
`sort(bool $saveKeys = false, $sort_flags = SORT_REGULAR): ArrayCollection`-  Sort an collection and maintain index association
##### params
_saveKeys_  - save keys of original collection
_sort_flags_ - You may modify the behavior of the sort using the optional parameter sort_flags,
# slice
`slice(int $offset, int $length = null, bool $preserve_keys = false): ArrayCollection` - Extract a slice of the collection
##### params
_offset_
* If offset is non-negative, the sequence will start at that offset in the collection.
* If offset is negative, the sequence will start that far from the end of the collection.

_length_
* If length is given and is positive, then the sequence will have up to that many elements in it.
* If the collection is shorter than the length, then only the available collection elements will be present.
* If length is given and is negative then the sequence will stop that many elements from the end of the collection.
* If it is omitted, then the sequence will have everything from offset up until the end of the collection.
# inCollection
`contains($needle, bool $strict = false): bool` -  Checks if a value exists in collection
##### params
_needle_ -The searched value.
_strict_ - If the third parameter strict is set to **TRUE** then the inCollection() function will also check the types of the needle in the haystack.
# containsLeastOne
`containsLeastOne($needle, bool $strict = false): bool` -  Checks if at least one value exists in the collection
# sortBy
`sortBy(callable $callback, bool $saveKeys = true): ArrayCollection` -  Sorts the collection by the field returned in callback function 
# groupBy
`groupBy(callable $callback): ArrayCollection` -  Group the collection by the field returned in callback function 
# isEmpty
`isEmpty(): bool` -  Group the collection by the field returned in callback function 
# skip
`skip(int $offset, bool $saveKeys = true): ArrayCollection` -  Returns the entire collection, skipping the first $offset elements
# take
`take(int $length, bool $saveKeys = true): ArrayCollection` -  returns the collection, discarding everything after $length element
