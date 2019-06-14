FF\Runtime | Fast Forward Components Collection
===============================================================================

by Marco Stoll

- <marco.stoll@rocketmail.com>
- <http://marcostoll.de>
- <https://github.com/marcostoll>
- <https://github.com/marcostoll/FF-Runtime>
------------------------------------------------------------------------------------------------------------------------

# What is the Fast Forward Components Collection?
The Fast Forward Components Collection, in short **Fast Forward** or **FF**, is a loosely coupled collection of code 
repositories each addressing common problems while building web application. Multiple **FF** components may be used 
together if desired. And some more complex **FF** components depend on other rather basic **FF** components.

**FF** is not a framework in and of itself and therefore should not be called so. 
But you may orchestrate multiple **FF** components to build an web application skeleton that provides the most common 
tasks.

# Introduction

This package introduces three different handler classes for registering as callbacks to one of the three runtime events 
of the php engine (error, exception, shutdown). The handlers make use of the **FF-Events** package to translate php's
core event information to **FF-Events** event instances.

# The Handlers

All handlers implement the `RuntimeEventHandlerInterface` which lets you `register()` them on demand.
The `ErrorHandler` as well as the `ExceptionHandler` each are aware of any previous handlers that might have been 
registered to their runtime events and let you restore the previous state. When registering shutdown handlers no
information regarding the previous state is provided by php.

The handlers fire their own events containing all available event data which makes it easy for you to handle them by
subscribing to the `FF\Events\EventBroker`.

Example:

    use FF\Events\EventBroker;
    use FF\Runtime\ErrorHandler;
    use FF\Runtime\Events\OnError;
    
    // register the ErrorHandler
    (new ErrorHandler())->register();
    
    // subscribe to the Runtome\OnError event
    EventBroker::getInstance()->subscribe(
        'Runtime\OnError',
        function (OnError $event) {
            // handle the event data
            var_dump($event->getErroNo(), $event->getErrMsg());  
        }
    };    

# Road map

