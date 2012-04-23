Identity Generator
==================

Provide a standard interface for generating unique identifiers.

The purpose of this library is to solve the problem of generating
unique values that are "guaranteed" to be unique and are suitable
to be used as an identity for objects.


Why?
----

While it is generally not a problem for data stores that implement
sequential or auto increment ID fields natively to provide a
guaranteed unique identity, there are use cases where it makes
sense to randomize identity such that it is not able to be guessed
as it follows no predictable pattern.

As such, most of the `GeneratorInterface` implementations provided
by this library will be somewhat random in nature. This does not
preclude the use of sequential `GeneratorInterface` implementations.


Mobs
----

Mobs are used to group identities. If a mob is specified, the
value requested to be stored by the data store need only be
unique to that mob. This allows a single data store to potentially
store and manage unique identities across several namespaces.

The name 'group' can be ambiguous (and is a reserved word for potential
data stores) so 'mob' was chosen based on the definition:

> any group or collection of persons or things.



The "Uniqueness Guarantee"
--------------------------

The uniqueness guarantee is accomplished by attempting to add
a generated value to a data store. The data store needs to be
capable of knowing whether or not the value passed in is unique.
This guarantee of uniqueness is only as strong as the given
data store's ability to effectively determine uniqueness of a
given value.

A data store should throw `NonUniqueIdentityException` in the
case that a given value is not unique. The requested identity
and mob values are available via this exception.


What About Collisions?
----------------------

The `IdentityGenerator` will make `maxRetries` attempts to
store generated values into the data store. This should allow
for handling a finite number of collisions gracefully.

Should `maxRetries` be exhausted, `GenerateException` is thrown.
It will contain a list of `NonUniqueIdentityException` exceptions
equal to the number of `maxRetries`.



Requirements
------------

 * PHP 5.3+


License
-------

This library is licensed under the New BSD License - see the LICENSE file
for details.


Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.