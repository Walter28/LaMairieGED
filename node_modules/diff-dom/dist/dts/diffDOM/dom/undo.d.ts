import { DiffDOMOptions, diffType } from "../types";
import { Diff } from "../helpers";
export declare function undoDOM(tree: Element, diffs: (diffType | Diff)[], options: DiffDOMOptions): void;
