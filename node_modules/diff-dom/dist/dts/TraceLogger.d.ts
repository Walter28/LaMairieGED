/**
 * Use TraceLogger to figure out function calls inside
 * JS objects by wrapping an object with a TraceLogger
 * instance.
 *
 * Pretty-prints the call trace (using unicode box code)
 * when tracelogger.toString() is called.
 */
/**
 * Wrap an object by calling new TraceLogger(obj)
 *
 * If you're familiar with Python decorators, this
 * does roughly the same thing, adding pre/post
 * call hook logging calls so that you can see
 * what's going on.
 */
export declare class TraceLogger {
    messages: string[];
    pad: string;
    padding: string;
    tick: number;
    constructor(obj?: {});
    fin(fn: string, args: string | HTMLElement | number | boolean | false | (string | HTMLElement | number | boolean | false)[]): void;
    fout(fn: string, result: string | HTMLElement | number | boolean | false | (string | HTMLElement | number | boolean | false)[]): void;
    format(s: string, tick: number): string;
    log(...args: any[]): void;
    toString(): string;
}
